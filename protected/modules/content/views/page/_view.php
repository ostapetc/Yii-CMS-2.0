<div class="page">
    <table>
        <tr>
            <td>
                <? if ($data->image_src): ?>
                    <?=
                    CHtml::link(
                        CHtml::image($data->image_src, '', ['class' => 'img-polaroid']),
                        $data->url,
                        [
                            'class' => 'page-img'
                        ]
                    );
                    ?>
                <? endif ?>
            </td>
            <td>
                <h1 class="page-title">
                    <?=
                    CHtml::link(
                        CHtml::encode($data->title),
                        $data->url,
                        ['class' => 'page-title']
                    );
                    ?>
                </h1>
                <div class="preview">
                    <?= $data->text_preview ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?=
                $this->renderPartial(
                    'application.modules.content.views.pageSection._list',
                    ['sections' => $data->sections]
                );
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?=
                $this->renderPartial(
                    'application.modules.tags.views._list',
                    ['tags' => $data->tags]
                );
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?=
                $this->renderPartial(
                    '_infoPanel',
                    ['page' => $data]
                );
                ?>
            </td>
        </tr>
    </table>
</div>
