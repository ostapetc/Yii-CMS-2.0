<h4>Поиск по видео</h4>
<?= CHtml::beginForm('/media/mediaVideo/manage', 'get') ?>
    <div class="input-append">
        <input style="width: auto;" type="text" name="q" />
        <input class="btn" type="submit" value="Найти" />
    </div>
<?= CHtml::endForm() ?>
