<? if ($sections): ?>
    <table class="table table-bordered">
        <tr>
            <th></th>
            <th><?= t('Раздел') ?></th>
            <th><?= t('Последний топик') ?></th>
            <th width="1"><?= t('Топиков') ?></th>
            <th width="1"><?= t('Комментарий') ?></th>
        </tr>
        <? foreach ($sections as $section): ?>
            <tr>
                <td>

                </td>
                <td>
                    <?= CHtml::link($section->name, '/') ?>
                </td>
                <td>
                    <?= CHtml::link($section->last_topic->title, $section->last_topic->url) ?>
                    <?= $section->last_topic->url ?>
                </td>
                <td style="text-align: center;">
                    <?= $section->pages_count ?>
                </td>
                <td style="text-align: center;">
                    <?= $section->comments_count ?>
                </td>
            </tr>
        <? endforeach ?>
    </table>
<? else: ?>
    <blockquote><?= t('разделы форума не найдены') ?></blockquote>
<? endif ?>

