<?
if ($type)
{
    $this->page_title = $type == 'in' ? t('Входящие заявки') : t('Исходящие заявки');
}
else
{
    $this->page_title = Yii::app()->user->id == $user->id  ? t('Ваши друзья') : t('Друзья') . ' ' . $user->name;
}
?>

<?
$this->widget('BootListView', array(
    'dataProvider' => $data_provider,
    'itemView'     => 'application.modules.users.views.user._view',
    'viewData'     => array(
        'count' => $data_provider->itemCount
    )
));
?>