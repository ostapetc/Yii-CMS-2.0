<div class="page">
    <? if ($preview): ?>
        <h1 class="page-title"><?= CHtml::link(CHtml::encode($data->title), $data->href, array('class' => 'page-title')); ?></h1>
    <? endif ?>

    <div class="sections">
        <a title="Вы не подписаны на этот хаб" class="section " href="http://habrahabr.ru/hub/copyright/">Копирайт</a>,
        <a title="Вы не подписаны на этот хаб" class="section " href="http://habrahabr.ru/hub/oracle/">Oracle</a>,
        <a title="Вы не подписаны на этот хаб" class="section " href="http://habrahabr.ru/hub/google/">Google</a>
    </div>

    <? if (isset($preview) && $preview): ?>
        <?= array_shift(explode('{{cut}}', $data->text)); ?>
        <p><?= CHtml::link('читать далее →', $data->href, array('class' => 'read-more')) ?></p>
    <? else: ?>
        <?= $data->text ?>
    <? endif ?>

    <? $this->widget('fileManager.portlets.ImageGallery', array(
        'model' => $data,
        'tag' => 'gallery',
        'cssFile' => '/css/site/post_image_carousel.css',
        'htmlOptions' => array('class'=>'post_image_carousel'),
        'size' => array('width'=>150, 'height' => 200)
    )) ?>

    <ul class="tags">
        <? foreach ($data->tags as $i => $tag): ?>
            <? if ($i > 0): ?>, <? endif ?>
            <li><a rel="tag" href="<?= $this->createUrl("/pages/tag/{$tag->name}"); ?>"><?= $tag->name ?></a></li>
        <? endforeach ?>
    </ul>

    <div class="infopanel">
        <div class="voting">
            <? if (Yii::app()->user->isGuest): ?>
                <span title="Голосовать могут только зарегистрированные пользователи" class="plus"></span>
                <span title="Голосовать могут только зарегистрированные пользователи" class="minus"></span>
            <? else: ?>
                <a title="Голосовать за" class="plus"></a>
                <a title="Голосовать против" class="minus"></a>
            <? endif ?>


            <div class="mark">
                <span title="Результат голосования виден только авторизованным пользователям" class="score">&mdash;</span>
            </div>
        </div>

        <div class="published">23 мая 2012, 22:28</div>

        <div class="favorite">
            <a title="Только зарегистрированные пользователи могут добавлять посты в избранное" onclick="return false;" href="#" class="guest"></a>
        </div>

        <div title="Количество пользователей, добавивших пост в избранное" class="favs_count">12</div>

        <div class="author">
            <a href="http://habrahabr.ru/users/Mairon/" title="Автор текста">Mairon</a>
            <span title="рейтинг пользователя" class="rating">472,1</span>
        </div>

        <div class="comments">
            <a href="http://habrahabr.ru/post/144422/#comments" title="Читать комментарии"><span class="all">68</span> </a>
        </div>
    </div>
</div>
<br clear="all"/>

<? if (!$preview): ?>
    <?= $this->widget('CommentsPortlet', array('model' => $data)); ?>
<? endif ?>




