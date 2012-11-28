<?
/**
 * ESitemapAction.php File
 *
 * Based on the post by Jacmoe at http://www.yiiframework.com/forum/index.php?/topic/670-yiic-sitemap-generation/page__pid__84510#entry84510
 *
 *
 * @package ESitemap
 */

Yii::import('ext.sitemap.*');
/**
 * Render the sitemap in human readable format, this will be rendered within the
 * main site layout.
 *
 * Usage:
 * <pre>
 *    public function actions()
 *     {
 *        return array(
 *            'sitemap'=>array(
 *                'class'=>'ext.sitemap.ESitemapAction',
 *            ),
 *             'sitemapxml'=>array(
 *                'class'=>'ext.sitemap.ESitemapXMLAction',
 *                'classConfig'=>array(
 *                    array('baseModel'=>'Task',
 *                          'route'=>'/task/view',
 *                          'params'=>array('id'=>'taskId')),
 *                ),
 *                'importListMethod'=>'getBaseSiteUrls',
 *            ),
 *        );
 *    }
 * </pre>
 *
 * @author  Dana Luther <dluther@internationalstudent.com>
 * @version 1.1
 */
class ESitemapAction extends CAction
{

    /**
     * @var string The view to be rendered. The view file should be stored in
     * the standard controller views subdirectory
     */
    public $sitemapView = 'sitemap';

    /**
     * @var string Alternate layout to be used by this action
     */
    public $layout;


    /**
     * @var array[] The list of arrays containing the loc|priority|frequency
     * key-pair values to generate the sitemap
     */
    public $list = array();

    /**
     * @var array[] The list of arrays containing configuration information on
     * classes to automatically generate pages for.
     * Usage:
     * <pre>
     * array(
     *  'baseModel'=>'Task',
     *  'route'=>'/task/view',
     *    'params'=>array('id'=>'taskId')),
     * </pre>
     * Where the params array is a list of uri_keys associated to model_attributes
     */
    public $classConfig = array();

    /**
     * @var string The base controller method which will provide any non-class
     * based links to be used with the auto-generated list
     */
    public $importListMethod;

    /**
     * @var string[] Array of strings to be imported for access to models which
     *        may be outside the standard import path
     * @since 1.1
     */
    public $import;


    public function initializeList()
    {
        // Ensure we have access to all the models we might need
        if ($this->import !== null)
        {
            if (!is_array($this->import)) {
                $this->import = array($this->import);
            }

            foreach ($this->import as $inc) {
                Yii::import($inc);
            }
        }

        // Set the initial list of primary static pages
        if ($this->importListMethod !== null)
        {
            $importListMethod = $this->importListMethod;
            $this->list       = $this->controller->$importListMethod();
        }

        $this->attachBehavior('esitemap', array('class'=> 'ESitemapBehavior'));

        if (empty($this->list) && empty($this->classConfig))
        {
            throw new CException('Trying to map non-existant content.');
        }

        $this->list = $this->populateSitemap($this->list, $this->classConfig);
    }


    /**
     * Execute the action
     */
    public function run()
    {
        // based on CViewAction - if layout is set, cache the current and
        // apply the specific alternate
        if ($this->layout !== null)
        {
            $layout             = $controller->layout;
            $controller->layout = $this->layout;
        }

        $this->initializeList();
        $controller = $this->getController();

        $controller->render('ext.sitemap.views.' . $this->sitemapView, array('list'=> $this->list));

        // If using alternate layout, return to the original controller layout
        if ($this->layout !== null) {
            $controller->layout = $layout;
        }
    }
}

?>