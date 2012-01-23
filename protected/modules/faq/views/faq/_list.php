<?php foreach ($faqs as $faq): ?>

    <span class='faq'><?php echo Yii::t('FaqModule.main', 'Вопрос'); ?>:</span> <br/>
    <?php echo $faq->question; ?>

    <br/>
    <br/>

    <span class='faq'><?php echo Yii::t('FaqModule.main', 'Ответ'); ?>:</span> <br/>
    <?php echo $faq->answer; ?>

    <div style="border-bottom:1px dotted gray;margin: 10px 0 10px 0"></div>

<?php endforeach ?>
