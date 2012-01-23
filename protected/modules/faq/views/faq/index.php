<?php $this->page_title = Yii::t('FaqModule.main', 'Часто задаваемые вопросы') . " :: {$section->name}"; ?>

<div class='submit_feedback'><a href="<?php echo $this->url("/faq/create"); ?>"><?php echo Yii::t('FaqModule.main', 'задать вопрос'); ?></a></div>
<br/>

<?php if (!$faqs): ?>
    <?php echo $this->msg(Yii::t('FaqModule.main', 'В данном разделе вопросы отсутствуют!'), 'info'); ?>
<?php endif ?>

<?php $this->renderPartial("_list", array('faqs' => $faqs)); ?>
