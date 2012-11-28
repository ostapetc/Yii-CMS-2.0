<h4>Поиск по видео</h4>
<?= CHtml::beginForm('/media/mediaVideo/manage', 'get') ?>
    <div class="input-append">
        <?
        $this->widget('zii.widgets.jui.CJuiAutoComplete', [
            'name' => 'q',
            'sourceUrl' => '/media/mediaVideo/autocomplete',
            'value' => isset($_GET['q']) ? $_GET['q'] : '',
            'htmlOptions' => [
                'style' => 'width: auto'
            ]
        ]);
        ?>

        <input class="btn" type="submit" value="Найти" />
    </div>
<?= CHtml::endForm() ?>
