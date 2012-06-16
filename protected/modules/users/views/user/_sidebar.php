<?
if ($model->id == Yii::app()->user->id)
{
    echo CHtml::link('Редактировать личные данные', $this->createUrl('/users/user/edit', array('userId' => $model->id)));
    echo '<br/>';
}
echo CHtml::link('Альбомы пользователя ('.$model->file_albums_count.')', $this->createUrl('/fileManager/fileAlbum/userAlbums', array('userId' => $model->id)));
