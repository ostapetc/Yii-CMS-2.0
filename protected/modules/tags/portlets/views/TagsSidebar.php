<ul class="nav nav-list page-info-sidebar">
    <? foreach ($tags as $tag): ?>
        <li>
            <?= CHtml::link($tag->name, ['index', 'tag_id' => $tag->id], ['class' => 'tags-link']) ?>
            <span class="badge badge-info"><?= $tag->rels_count ?></span>
        </li>
    <? endforeach ?>
</ul>
