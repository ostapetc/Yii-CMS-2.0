<?
/**
 * ESitemapModel.php File
 *
 * @package ESitemap
 * @subpackage
 * @created 09/03/2011 10:40:00
 */

/**
 * The ESitemapModel maps the class configuration options to
 * the actual data records and interprets that informaiton for use
 * by the sitemap processor
 *
 * @author    Dana Luther <dluther@internationalstudent.com>
 * @copyright (c) Envisage International, Corp.
 * @version   1.1
 */
class ESitemapModel extends CModel
{

    /**
     * @var string The frequency that the link is updated.
     * Can be: never, hourly, daily, weekly, monthly, yearly
     */
    public $title = 'title';
    /**
     * @var string The frequency that the link is updated.
     * Can be: never, hourly, daily, weekly, monthly, yearly
     */
    public $frequency = 'yearly';
    /**
     * @var string The priority to weight the listing as -- defaults to 0.5
     * Should be a string representation of a number between 0.1 and 1.0
     */
    public $priority = '0.5';
    /**
     * @var string The primary route that the model's view path should contain
     */
    public $route = 'site/';

    /**
     * @var string The model class name that will be queried for content
     */
    public $baseModel;
    /**
     * @var string The model scope that sets the proper select/filter/order
     * criteria for the model type
     */
    public $scopeName = 'sitemap';

    /**
     * @var boolean Use ActiveRecord or DAO. TRUE - AR, FALSE - DAO
     */
    public $useARorDAO = TRUE;

    /**
     * @var string[] The uri_variable_name => model_attribute_name key pairs to
     * be used with the route for the page url
     */
    public $params = array();

    /**
     * @var string The cache'd path string for all models of this type.
     * @access private
     */
    protected $_pathFormat;


    /**
     * Rules for the model
     *
     * @return array[] validation rule configurations
     */
    public function rules()
    {
        return array(
            array('frequency,priority,route,baseModel,scopeName', 'required'), array('useARorDAO', 'boolean'),
            array('params,import', 'safe'),
        );
    }


    /**
     * Available attributes for this model
     *
     * @return string[] List of attribute names
     */
    public function attributeNames()
    {
        return array('frequency', 'priority', 'route', 'params', 'baseModel', 'scopeName');
    }


    /**
     * Get the list of models which will populate the active sitemap list
     *
     * @return CActiveRecord[] The extended active record classes to be used
     */
    public function getModels()
    {
        if ($this->useARorDAO)
        {
            $scope = $this->scopeName;
            return CActiveRecord::model($this->baseModel)->$scope()->findAll();
        }

        $model  = new $this->baseModel;
        $scopes = $model->scopes();
        $scope  = array_merge($scopes[$this->scopeName], array('from'=> $model->tableName()));

        return Yii::app()->db->createCommand($scope)->queryAll();
    }


    /**
     * Format the route and params as a url path
     * Save the result to a local cache so we're only looking this up once per model type
     *
     * @return string
     */
    public function getPathFormat()
    {
        if ($this->_pathFormat === null)
        {
            $routeParams = array();
            foreach ($this->params as $key=> $attribute)
            {
                $routeParams[$key] = $this->formatParam($attribute);
            }

            $this->_pathFormat = Yii::app()->createAbsoluteUrl($this->route, $routeParams);

            // NOTE +++++++++++++
            // When unit testing, if you don't have a SERVER_NAME defined, the
            // absolute url will fail, so toggle this on instead if including that test
            //$this->_pathFormat = Yii::app()->createUrl($this->route, $routeParams);
        }
        return $this->_pathFormat;
    }


    /**
     * Replace all the slugs in the standardized path with the specific details
     * for a given model.
     *
     * @param CActiveRecord $model The model whose attributes should be used to
     *                             generate the URL string for the loc property of the sitemap
     *
     * @return string The formatted full URL path for the given model
     */
    public function loc($model)
    {

        if ($model === null)
        {
            throw new CException('No model set for path.');
        }
        $path = $this->pathFormat;

        $keys = array();
        $vals = array();
        foreach ($this->params as $key => $attr)
        {
            $keys[] = $this->formatParam($attr);
            $vals[] = is_array($model) ? $model[$attr] : $model->$attr;
        }
        $str = str_replace($keys, $vals, $path);
        return $str;
    }


    /**
     * Ensure we're always looking for matching slugs
     *
     * @param string $str the attribute field to mark
     *
     * @return string
     */
    protected function formatParam($str)
    {
        return "__" . $str . "__";
    }
}


?>
