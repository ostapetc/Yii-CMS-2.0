<?
Yii::app()->clientScript->registerScriptFile('/js/social/friends.js');

switch (true)
{
    case $type == 'in':
        $this->page_title = t('Входящие заявки');
        break;

    case $type == 'out':
        $this->page_title = t('Исходящие заявки');
        break;

    case Yii::app()->user->id == $user->id:
        $this->page_title = t('Ваши друзья');
        break;

    default:
        $this->page_title = t('Друзья') . ' ' . $user->name;
        break;
}

$this->widget('ListView', array(
    'dataProvider' => $data_provider,
    'itemView'     => 'application.modules.users.views.user._view',
    'viewData'     => array(
        'count' => $data_provider->itemCount
    )
));
