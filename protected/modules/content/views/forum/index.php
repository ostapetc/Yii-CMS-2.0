<style type="text/css">
    .table th {
        border-top: 0 !important;
    }
</style>

<? if ($sections): ?>
    <table class="table table-hover">
        <tr>
            <th width="1"></th>
            <th><?= t('Раздел') ?></th>
            <th><?= t('Последний топик') ?></th>
            <th width="1"><?= t('Топиков') ?></th>
            <th width="1"><?= t('Комментарий') ?></th>
        </tr>
        <? foreach ($sections as $section): ?>
            <tr>
                <td>
                    <span class="glyphicon glyphicon-announcement "></span>
                </td>
                <td>
                    <?= CHtml::link($section->name, '') ?>
                </td>
                <td>
                    <? if ($section->last_topic): ?>
                        <?= CHtml::link($section->last_topic->title, $section->last_topic->url) ?> <br/>

                        <div style="float:left">
                            <? $this->renderPartial('application.modules.users.views.user._author', ['user' => $section->last_topic->user]) ?>
                        </div>
                        <div class="published" style="float:right"><?= $section->last_topic->value('date_create') ?></div>
                    <? else: ?>
                        <span class="span.italic-12">отсутсвует</span>
                    <? endif ?>
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

