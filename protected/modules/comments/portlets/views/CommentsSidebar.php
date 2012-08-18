<style type="text/css">
    .s-comment {
        background-color: #ffffff !important;
        padding: 4px !important;
        border-radius: 5px;
    }

    .s-comment .user-link {
        color: gray !important;
    }

    .s-comment .user-photo-link {
        float: left;
        margin-right: 5px;
        margin-left: 5px !important;
        margin-top: 5px !important;
    }

    .s-comment a {
        font-size: 13px !important;
    }

</style>


<? foreach ($comments_list as $title => $comments): ?>
    <h4><?= $title ?></h4>
    <br/>
    <? foreach ($comments as $comment): ?>
        <div class="s-comment">
            <?= $comment->user->photo_link ?>
            <?= $comment->user->link ?> →
            <?= CHtml::link(Yii::app()->text->cut($comment->text, 130), "/", array('class' => 'l-comment')); ?>
        </div>
        <br clear="all" />
    <? endforeach ?>
<? endforeach ?>