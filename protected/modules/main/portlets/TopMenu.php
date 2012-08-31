<?

class TopMenu extends Portlet
{
    public function renderContent()
    {
        $items = Yii::app()->controller->topMenuItems();

        $this->render('TopMenu', array(
            'items' => $items
        ));
    }
}
