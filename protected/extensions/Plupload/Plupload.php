<?php

class Plupload extends CWidget 
{
    public $flash_swf_url = 'plupload.flash.swf';

    public $silverlight_xap_url = 'plupload.silverlight.xap';

	public $url = '';

	public $runtimes = 'flash,silverlight,browserplus,html5';

	public $max_file_size = '10mb';

    //public $resize = '{width : 320, height : 240, quality : 90}';

    public $resize = '{width : "100%", height : "100%", quality : 100}';

	public $chunk_size;

	public $unique_names = true;

	public $browse_button;

	public $drop_element;

	public $container;

	public $multipart = true;

	public $multipart_params;

	public $required_features;

	public $headers;

	public $preinit;

	public $dragdrop = false;

	public $rename = false;

	public $multiple_queues = true;

	public $urlstream_upload;

	public $filters = '[{
			title : "Standart files",
			extensions : "jpg, gif, png, jpeg, txt, doc, zip, rar, docx, rtf, dotx, ppsx, pptm
						  pptx, xlsm, xlsx"
		}]';

    private $_js_path;


	public function run() 
	{
	    $this->registerScripts();
        $this->renderMarkup();
	}


    public function registerScripts()
    {
        $assets_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets_path = Yii::app()->getAssetManager()->publish($assets_path) . DIRECTORY_SEPARATOR;

        $css_path = $assets_path . 'css' . DIRECTORY_SEPARATOR;
        $js_path  = $assets_path . 'js' . DIRECTORY_SEPARATOR;

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($css_path . 'plupload.queue.css');
        $cs->registerScriptFile($js_path . 'gears_init.js');
        $cs->registerScriptFile($js_path . 'browserplus-min.js');
        $cs->registerScriptFile($js_path . 'plupload.full.min.js');
        $cs->registerScriptFile($js_path . 'jquery.plupload.queue.min.js');
        $cs->registerScriptFile($js_path . 'plupload.i18n.ru.js');

        $this->_js_path = $js_path;
    }


    public function renderMarkup()
    {
        $vars = get_object_vars($this);

        unset($vars['_js_path']);

        $vars['filters'] = str_replace(array("\n", "\t"), null, $vars['filters']);

        $object = new stdClass();
        foreach ($vars as $name => $value)
        {
            if (is_null($value))
            {
                continue;
            }

            if (in_array($name, array('silverlight_xap_url', 'flash_swf_url')))
            {
                $value = $this->_js_path . $value;
            }

            $object->$name = $value;
        }

        $object = str_replace(
            array('\/', ']"', '"[', '\"', '"{', '}"'),
            array('/', ']', '[', "'", '{', '}'),
            CJSON::encode($object)
        );

        echo '
            <script type="text/javascript">
                $(function()
                {
                    $("#uploader").pluploadQueue(' . $object . ');
                });
            </script>

            <div id="uploader">
                <p>You browser doesn\'t have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
            </div>';
    }
}