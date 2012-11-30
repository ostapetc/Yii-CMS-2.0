<br clear="all" />
<div class="model-panel">
    <i class="icon-user"></i> <?= $page->user->link ?> <span class="user-rating"><?= $page->user->rating ?></span> &nbsp; |
    <i class="icon-calendar"></i> <span class="info-panel-date"><?= $page->value('date_create') ?></span> |
    <i class="icon-comment"></i> <a href="<?= $page->url ?>#comments"><?= t('{n} comments', $page->comments_count) ?></a> |
    <? $this->widget('social.portlets.FavoriteWidget', ['model' => $page]); ?> |
    <? $this->widget('social.portlets.RatingWidget', ['model' => $page]); ?>
</div>


