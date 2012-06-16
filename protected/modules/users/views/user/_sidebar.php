<?
$this->beginClip('sidebar');
    if ($model->id == Yii::app()->user->id)
    {
        echo CHtml::link('Редактировать личные данные', $this->createUrl('/users/user/edit', array('userId' => $model->id)));
    }
    echo CHtml::link('Альбомы пользователя', $this->createUrl('/fileManager/fileAlbum/userAlbums', array('userId' => $model->id)));
$this->endClip('sidebar');
