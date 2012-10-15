<?

Yii::import('zii.widgets.jui.CJuiWidget');

class Uploader extends JuiInputWidget
{
    public $model;
    public $title = 'Файлы';
    public $preview_width = '64px';
    public $data_type; //image, sound, video, document
    public $as_modal = true;
    public $multiple = true;

    public $fields = array(
        'title' => array(
            'header' => 'Название',
            'size'   => 150,
            'type'   => 'text',
        ),
        'descr' => array(
            'header' => 'Описание',
            'size'   => 250,
            'type'   => 'textarea',
        ),
    );

    /*
     * image: see http://www.verot.net/php_class_upload_samples.htm or comments in Resizer class
     * document: nothing yet
     * sound: nothing yet
     * video: nothing yet
    */
    public $params = array();

    public $tag;
    public $api = 'local';
    public $maxFileSize = 100000000; //100 * 1000 * 1000

    public $upload_url;
    public $link_parser_url;
    public $assets;

    public $upload_action = '/media/mediaFileAdmin/upload';
    public $sortable_action = '/media/mediaFileAdmin/savePriority';
    public $exist_files_action = '/media/mediaFileAdmin/existFiles';
    public $link_parser_action = '/media/mediaFileAdmin/linkParser';

    private $allow_type = array(
        'document'=> 'js:/(\.|\/)(svg\+xml|doc|docx|txt|zip|rar|xml)$/i',
        'image'   => 'js:/(\.|\/)(gif|jpeg|png|jpg|tiff)$/i',
        'sound'   => 'js:/(\.|\/)(mp3|wav)$/i',
        'any'     => 'js:/(\.|\/)(.*)$/i',
        'video'   => 'js:/(\.|\/)(mp4|flv|wmv)$/i'
    );

    private static $isTemplatesRender = false;


    public function init()
    {
        parent::init();

        $behaviorAttached = false;
        foreach ($this->model->behaviors() as $id => $data)
        {
            if ($this->model->asa($id) instanceof FileManagerBehavior)
            {
                $behaviorAttached = true;
                break;
            }
        }
        if (!$behaviorAttached)
        {
            throw new CException('Требуется подключение behavior FileManagerBehavior в моделе!');
        }

        $this->initVars();
        $this->registerScripts();
    }


    public function initVars()
    {
        if ($this->model === null)
        {
            throw new CException('Параметр model является обязательным');
        }

        if (!in_array($this->data_type, array(
            'image',
            'sound',
            'video',
            'document',
            'any'
        ), true)
        )
        {
            throw new CException('Параметр data_type является обязательным  и может принемать значения: image, sound, video, document');
        }

        if ($this->tag === null)
        {
            $this->tag = $this->attribute;
        }

        $this->id     = 'uploader_' . get_class($this->model) . $this->tag;
        $this->assets = Yii::app()->getModule('media')->assetsUrl();

        $url_data = array(
            'model_id'  => get_class($this->model),
            'object_id' => $this->model->id ? $this->model->id : 0,
            'data_type' => $this->data_type,
            'tag'       => $this->tag,
        );

        if (!$this->upload_url)
        {
            $this->upload_url = $this->createUrl($this->upload_action, $url_data);
        }

        if (!$this->link_parser_url)
        {
            $this->link_parser_url = $this->createUrl($this->link_parser_action, $url_data);
        }

        $default      = array(
            'url'                     => $this->upload_url,
            'dropZone'                => "js:$('#{$this->id}-drop-zone')",
            'maxFileSize'             => $this->maxFileSize,
            'acceptFileTypes'         => $this->allow_type[$this->data_type],
//            'maxChunkSize'          => 1*1000*1000,
            'sortableSaveUrl'         => $this->createUrl($this->sortable_action),
            'linkParserUrl'           => $this->link_parser_url,
            'limitConcurrentUploads'  => 0,
            'existFilesUrl'           => $this->createUrl($this->exist_files_action, array(
                'model_id'  => get_class($this->model),
                'object_id' => $this->model->id ? $this->model->id : 0,
                'tag'       => $this->tag
            )),
        );
        $this->params = CMap::mergeArray($default, $this->params);
    }


    public function createUrl($url, $params = array())
    {
        $params['api'] = $this->api;
        return Yii::app()->createUrl($url, $params);
    }


    public function registerScripts()
    {
        $plugins = $this->assets . '/plugins/';
        $cs      = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery.ui')->registerScriptFile($plugins . 'tmpl/jquery.tmpl.min.js');
        $cs->registerScriptFile($plugins . 'jFileUpload/cors/jquery.postmessage-transport.js');
        $cs->registerScriptFile($plugins . 'jFileUpload/cors/jquery.xdr-transport.js');
        $cs->registerScriptFile($plugins . 'jFileUpload/jquery.fileupload.js');
        $cs->registerScriptFile($plugins . 'jFileUpload/jquery.iframe-transport.js');
        $cs->registerScriptFile($plugins . 'jFileUpload/jquery.fileupload-fp.js');
        $cs->registerScriptFile($plugins . 'jFileUpload/jquery.fileupload-ui.js');
        $cs->registerScriptFile($plugins . 'jEditable/jquery.jeditable.js');
        $cs->registerScriptFile($plugins . 'moderniz/moderniz.js');
        $cs->registerScriptFile($plugins . 'jFileUpload/cmsUI.fileupload.js');
        $cs->registerCssFile($plugins . 'jFileUpload/css/jquery.fileupload-ui.css');

        $params = CJavaScript::encode($this->params);

        $cs->registerScript('uploader_' . $this->id, "$('#{$this->id}').fileupload({$params});");
    }


    public function run()
    {
        if (!self::$isTemplatesRender)
        {
            $this->render('uploaderTemplates');
            self::$isTemplatesRender = true;
        }
        if ($this->as_modal)
        {
            $this->renderDialog('uploader', array(
                'title'      => $this->title,
                'linkOptions'=> array(
                    'class'=> 'btn btn-info'
                )
            ));
        }
        else
        {
            $this->render('_uploader');
        }
    }
}

