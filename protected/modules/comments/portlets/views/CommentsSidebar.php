<h4>Комментарии</h4>

<? if ($comments): ?>
    <ul class="comments-ul">
        <? foreach ($comments as $comment): ?>
        <li>
            <table>
                <tr  valign="top">
                    <td style="padding-right: 10px;">
                        <?= $comment->user->photo_link ?>
                    </td>
                    <td >
                        <div style="position: relative;width: 250px;">
                            <?= $comment->user->link ?>
                            <div class="date"><?= Yii::app()->dater->readableFormat($comment->date_create); ?></div>
                            <br clear="all" />
                            <?= CHtml::link(Yii::app()->text->cut($comment->text, 130), "/", array('class' => 'l-comment')); ?>
                        </div>
                    </td>
                </tr>
            </table>
        </li>
        <? endforeach ?>
    </ul>
<? else: ?>
    <span class="italic-12">Никто еще не оставлял комментарий</span>
<? endif ?>

