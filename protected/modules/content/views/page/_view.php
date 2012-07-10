<div class="page">
    <? if ($preview): ?>
        <h1 class="page-title">
            <?= CHtml::link(CHtml::encode($data->title), $data->href, array('class' => 'page-title')); ?>

            <? if (Yii::app()->user->checkAccess('Page_update')): ?>
                <?= CHtml::link(t('редактировать'), $this->createUrl('update', array('id' => $data->id)), array('class' => 'page-update')); ?>
            <? endif ?>
        </h1>
    <? endif ?>

    <? if ($data->sections): ?>
        <div class="sections">
            <? foreach ($data->sections as $i => $section): ?>
                <? if ($i > 0): ?>,  <? endif; ?>
                <?= CHtml::link($section->name, $this->createUrl('/page/section/' . $section->id), array('class' => 'section', 'title' => $section->name)); ?>
            <? endforeach ?>
        </div>
    <? endif ?>

    <? if (isset($preview) && $preview): ?>
        <?= array_shift(explode('{{cut}}', $data->text)); ?>
        <p><?= CHtml::link('читать далее →', $data->href, array('class' => 'read-more')) ?></p>
    <? else: ?>
        <?= $data->text ?>
    <? endif ?>

    <ul class="tags">
        <? foreach ($data->tags as $i => $tag): ?>
            <? if ($i > 0): ?>, <? endif ?>
            <li><a rel="tag" href="<?= $this->createUrl("/page/tag/{$tag->name}"); ?>"><?= $tag->name ?></a></li>
        <? endforeach ?>
    </ul>

    <div class="infopanel">
        <div class="voting">
            <?= $this->widget('RatingPortlet', array('model' => $data)); ?>
        </div>

        <div class="published"><?= Yii::app()->dateFormatter->formatDateTime($data->date_create, 'long', 'short') ?></div>

        <? $this->widget('FavoritePortlet', array('model' => $data)); ?>

        <div class="author">
            <a href="<?= $data->user->href ?>" title="Автор текста"><?= $data->user->name ?></a>
            <span title="рейтинг пользователя" class="rating"><?= $data->user->rating ?></span>
        </div>

        <div class="comments">
            <a href="<?= $data->href ?>#comments" title="Читать комментарии"><span class="all"><?= $data->comments_count ?></span> </a>
        </div>
    </div>
</div>
<br clear="all"/>

<? if (!$preview): ?>
    <?= $this->widget('CommentsPortlet', array('model' => $data)); ?>
<? endif ?>




