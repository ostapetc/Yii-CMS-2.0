<style type="text/css">
    #parser-form input, #parser-form label, #parser-form select{
        float: left;
    }

    #parser-form input, #parser-form select {
        margin-right: 15px;
    }

    #parser-form label {
        line-height: 30px;
        margin-right: 5px;
    }
</style>


<div id="parser-form">
    <?= CHtml::beginForm() ?>
    <?= CHtml::label('Parser', 'parser') ?>
    <?=
    CHtml::dropDownList('parser', '', array(
        'MixfightParser' => 'MixfightParser',
        'ValetudoParser' => 'ValetudoParser'
    ))
    ?>
    <?= CHtml::label('URL', 'url') ?>
    <?= CHtml::textField('url', '', array('width' => '1300')) ?>
    <?= CHtml::submitButton('ПУСК') ?>
    <?= CHtml::endForm() ?>
</div>

