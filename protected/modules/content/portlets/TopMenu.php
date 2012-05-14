<?

class TopMenu extends Portlet
{
    const ID = "1";


    public function renderContent()
    {
        $menu = Menu::model()->language()->published()->find("t.id = '" . self::ID . "'");
        if (!$menu)
        {
            return;
        }

        $this->render('TopMenu', array(
            'sections' => $menu->getSections()
        ));
    }
}
