<style type="text/css">
    .table th {
        border-top: 0 !important;
    }
</style>

<?
$this->widget('Crumbs', [
    'homeLink' => false,
    'links'    => [
        t('') => ''
    ]
]);
?>

<? if ($pages): ?>
    <table class="table table-hover">
        <tr>
            <th width="1"></th>
            <th><?= t('Топик') ?></th>
            <th><?= t('Последний ответ') ?></th>
            <th width="1"><?= t('Рейтинг') ?></th>
            <th width="1"><?= t('Ответов') ?></th>
            <th width="1"><?= t('Просмотров') ?></th>
        </tr>

        <? foreach ($pages as $page): ?>
            <tr>
                <td>
                    <span class="glyphicon glyphicon-bookmark "></span>
                </td>
                <td>
                    <?= CHtml::link($page->title, $page->forum_url) ?>
                </td>
                <td>
                    <? $last_comment = $page->last_comment; ?>
                    <? if ($last_comment): ?>
                        <div style="float:left">
                            <? $this->renderPartial('application.modules.users.views.user._author', ['user' => $last_comment->user]) ?>
                        </div>
                        <div class="published" style="float:right"><?= $last_comment->value('date_create') ?></div>
                    <? else: ?>
                        <span class="span.italic-12">отсутсвует</span>
                    <? endif ?>
                </td>
                <td class="align-center">
                    <?= Rating::getHtml($page, ['style' => 'float:none']) ?>
                </td>
                <td class="align-center">
                    <?= $page->comments_count ?>
                </td>
                <td class="align-center">
                    <?= $page->comments_count ?>
                </td>
            </tr>
        <? endforeach ?>
    </table>

    <div class="pagination">
        <?
        $this->widget('LinkPager', [
            'pages' => $pagination,
        ])
        ?>
    </div>

<? else: ?>
    <blockquote><?= t('топики раздела форума не найдены') ?></blockquote>
<? endif ?>