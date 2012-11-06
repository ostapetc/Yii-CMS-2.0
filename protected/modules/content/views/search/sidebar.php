<form action="#" id="search-full">
    <div class="control-group">
        <div class="control-label">Где ищем?</div>
        <div class="controls">
            <?
            $data = [
                'pages' => 'Посты',
                'video' => 'Видео',
                'audio' => 'Аудио',
                'albums' => 'Альбомы'
            ];
            foreach ($data as $value => $label)
            {
                $checked = in_array($value, $this->active_indexes);

            ?>
                <label class="checkbox">
                    <?
                    echo CHtml::checkBox('indexes[]', $checked, [
                        'value' => $value
                    ]);
                    ?>
                    <?= $label ?>
                </label>
            <?
            }
            ?>
        </div>
    </div>

    <input type="text" name="q" value="" placeholder="Что ищем" />
    <input type="submit" class="btn" value="Искать" />
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#search-full').submit(function()
        {
            var form = $('#search-full');
            $.bbq.set
            $.fn.yiiListView.update('search-result', {
                url: '/content/search/index?'+form.serialize()
            });
            return false;
        });
    });
</script>