<?

class LanguageSwitcherAdmin extends  Portlet
{
    public function renderContent()
    {
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/flags.css');
        $langs = Language::model()->findAll(array('order' => "id='ru' DESC"));
        if (count($langs) > 1)
        {
            $this->render('LanguageSwitcherAdmin', array('langs' => $langs));
        }
    }
}
