<?

class LanguageSwitcher extends Widget
{
    public function run()
    {
        $this->render('LanguageSwitcher', array(
            'languages' => Language::getList()
        ));
    }
}
