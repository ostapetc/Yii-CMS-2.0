<? if ($tags): ?>
    <div class="tags-box">
        <p>
            <span class="tags-title">Теги:</span>
            <? foreach ($tags as $i => $tag): ?>
                <a href="<?= $this->createUrl("/pages/tag/{$tag->name}"); ?>"><span class="label label-info"><?= $tag->name ?></span></a>
            <? endforeach ?>
        </p>
    </div>
<? endif ?>

