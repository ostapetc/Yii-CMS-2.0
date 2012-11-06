<?
class SearchController extends ClientController
{

    public static function actionsTitles()
    {
        return [
            'index' => 'Поиск',
        ];
    }

    public function sidebars()
    {
        return [
            [
                'actions'  => ['index'],
                'sidebars' => [
                    [
                        'type' => 'partial',
                        'class'=> 'content.views.search.sidebar'
                    ],
                ]
            ],
        ];
    }

    public $active_indexes;

    public function actionIndex()
    {
        $q = Yii::app()->request->getParam('q');
        $allow_indexes = ['pages', 'video', 'audio', 'albums'];
        $this->active_indexes = Yii::app()->request->getParam('indexes', $allow_indexes);
        $search = Yii::app()->search;
        $search->setFullText($q);
        $search->select('*')->from(implode(' ', $this->active_indexes));
        //->filters(array('project_id' => $this->_city->id));
//      $search->groupby($groupby)
        //      ->orderby(array('f_name' => 'ASC'))->limit(0, 30);

        $dp = $search->search();
        if ($dp->getTotalItemCount() == 0)
        {
            $q = Yii::app()->text->changeLayout($q);
            $dp = $search->setLastCriteria()->setFullText($q)->search();
        }

        $this->render('index', [
            'dp' => $dp,
        ]);
    }

}
