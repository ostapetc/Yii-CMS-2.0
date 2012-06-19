<br/>
<div class="row">
    <div class="span2">
        <?
        $avatar_size = array('width' => 170, 'height' => 100);
        $avatar = ImageHelper::thumb(User::PHOTO_PATH, $model->photo, $avatar_size, true);
        echo $avatar->isRealImage() ? $avatar : ImageHelper::placeholder($avatar_size);
        ?>
    </div>
    <div class="span3">
        <table class="table table-bordered table-striped">
            <tbody>
            <? if ($model->name) { ?>
                <tr>
                    <td>Имя</td>
                    <td><?= $model->name ?></td>
                </tr>
            <? } ?>
            <? if ($model->email) { ?>
                <tr>
                    <td>Email</td>
                    <td><?= $model->email ?></td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
</div>

<? $this->clips['sidebar'] .= $this->renderPartial('_sidebar', array('model' => $model), true) ?>