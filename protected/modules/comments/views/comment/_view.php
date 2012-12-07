<div class="comment"  style="margin-left: <?= (20 * ($comment->level - 1)) ?>px">
    <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 4px">
        <tr style="vertical-align: bottom">
            <td>
                <a name="comment_<?= $comment->id ?>"></a>
                <?= $comment->user->getPhotoLink(); ?>
            </td>
            <td>
                <?= $comment->user->getLink('commet-user') ?>
            </td>
            <td>
                <span class="date"><?= $comment->value('date_create') ?></span>
            </td>
            <td>
                <a class="hash" href="#comment_<?= $comment->id ?>">#</a>
            </td>
            <td>
                <?=
                CHtml::link('ответить', '', [
                    'class'        => 'answer',
                    'data-comment' => $comment->id,
                    'data-user'    => $comment->user->name,
                    'data-role'    => USer::ROLE_USER
                ])
                ?>
            </td>
            <td style="padding-left: 10px">
                <? $this->widget('application.modules.social.portlets.RatingWidget', array('model' => $comment)); ?>
            </td>
        </tr>
    </table>

    <div class="well">
        <?= CHtml::encode($comment->text); ?>
    </div>
</div>

