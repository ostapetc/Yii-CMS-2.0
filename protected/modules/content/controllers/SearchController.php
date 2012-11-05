<?
class SearchController extends ClientController
{

    public static function actionsTitles()
    {
        return [
            'index' => 'Поиск',
        ];
    }


    public function actionIndex()
    {
        foreach (Yii::app()->getModules() as $id => $config)
        {
            $module = Yii::app()->getModule($id);
            if (!method_exists($module, 'getSearchInfo'))
            {
                continue;
            }

            foreach ($module->getSearchInfo() as $index => $conf)
            {
                $conf['view'];
            }


        }
        $search = Yii::app()->search;
        $search->select('*')->from('index_pages');
        //$search->where($expression)
        //      ->filters(array('project_id' => $this->_city->id))->groupby($groupby)
        //      ->orderby(array('f_name' => 'ASC'))->limit(0, 30);
        $dp = new SphinxDataProvider($search->searchRaw());

        $this->render('index', ['dp' => $dp]);
    }



}
