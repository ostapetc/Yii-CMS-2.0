<?php $this->page_title = Yii::t('FaqModule.main', 'Добавление вопроса'); ?>

<?php if (Yii::app()->user->hasFlash('faq_form_success')): ?>
    <?php echo $this->msg(Yii::app()->user->getFlash('faq_form_success'), 'ok'); ?>
<?php else : ?>
    <?php echo $this->renderPartial("application.views.layouts._siteForm", array('form' => $form)); ?>
<?php endif ?>

