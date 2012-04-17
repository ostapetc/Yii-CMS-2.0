<?

class Sidebars extends Portlet
{
    public function renderContent()
    {
        $criteria = new CDbCriteria();
        $criteria->order = '`order` DESC';
        $criteria->condition = 'is_published = 1';

        $this->render('Sidebars', array(
            'sidebars' => Sidebar::model()->language()->published()->findAll($criteria)
        ));
    }
}
