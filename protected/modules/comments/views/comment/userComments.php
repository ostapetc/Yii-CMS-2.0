<?
$this->page_title = $user == Yii::app()->user->id ? t('Ваши комментарии') : t('Комментарии') . ' &rarr; ' . $user->name;
?>