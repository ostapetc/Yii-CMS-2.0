<?
$this->widget('BootListView', array(
    'id'           => 'Message-listView',
    'dataProvider' => $data_provider,
    'itemView'     => '_view'
));
?>

<?= CHtml::beginForm(); ?>
<table border="">
    <tr>
        <td></td>
        <td>
            <?= CHtml::textArea('Message[text]') ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?= CHtml::submitButton('Отправить', array('class' => 'btn btn-primary btn-small')) ?>
        </td>
        <td></td>
    </tr>
</table>
<?= CHtml::endForm(); ?>