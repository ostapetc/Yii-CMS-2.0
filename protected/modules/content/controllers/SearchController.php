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
        $q = Yii::app()->request->getParam('q');
        $search = Yii::app()->search->client;
        $search->SetMatchMode(SPH_MATCH_EXTENDED2);
        $search->SetRankingMode(SPH_RANK_SPH04);
        $search->SetSortMode(SPH_SORT_RELEVANCE);
        $a = $search->Query('агрессию', 'index_pages');
    dump($a);
        $search->select('*')->from('index_pages');
        $search->where($q);
        //->filters(array('project_id' => $this->_city->id));
//      $search->groupby($groupby)
        //      ->orderby(array('f_name' => 'ASC'))->limit(0, 30);
        $dp = new SphinxDataProvider($search->searchRaw());

        $this->render('index', ['dp' => $dp]);
    }



}
