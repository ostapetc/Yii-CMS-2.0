<?
/**
 * ESitemapXMLAction.php File
 *
 * Based on the post by Jacmoe at http://www.yiiframework.com/forum/index.php?/topic/670-yiic-sitemap-generation/page__pid__84510#entry84510
 *
 * @package ESitemap
 */

Yii::import('ext.sitemap.*');
/**
 * Description of ESitemapXMLAction
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
 *                //'bypassLogs'=>true,
 *            ),
 *        );
 *    }
 * </pre>
 *
 * @author  Dana Luther <dluther@internationalstudent.com>
 * @version 1.1
 */
class ESitemapXMLAction extends ESitemapAction
{

    /**
     * @var string The view to be rendered. The view file should be stored in
     * the standard controller views subdirectory
     */
    public $sitemapView = 'sitemapxml';

    /**
     * @var boolean Whether to exit directly from the action. This is necessary
     * when using some of the UI based web toolbars etc
     */
    public $bypassLogs;


    /**
     * Execute the action
     */
    public function run()
    {
        $this->initializeList();
        header('Content-Type: application/xml');
        $this->controller->renderPartial(
            'ext.sitemap.views.' . $this->sitemapView, array('list'=> $this->list));

        // If running some UI log routes, it will break XML. In that case, set
        // the bypassLogs param
        if ($this->bypassLogs) {
            exit();
        }
    }

}

?>
