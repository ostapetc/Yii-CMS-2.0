<? if ($tags): ?>
    <ul class="tags">
        <li><span class="glyphicon-tags"></span></li>

        <? foreach ($tags as $i => $tag): ?>
            <? if ($i > 0): ?>, <? endif ?>
            <li>
                <a rel="tag" href="<?= $this->createUrl("/pages/tag/{$tag->name}"); ?>"><?= $tag->name ?></a>
            </li>
        <? endforeach ?>
    </ul>
<? endif ?>

