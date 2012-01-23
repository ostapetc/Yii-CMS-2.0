<?php $this->page_title = Yii::t('ActionsModule.main', 'Мероприятия'); ?>

<?php $this->renderpartial('_list', array('actions' => $actions)); ?>

<?php $this->renderPartial('application.views.layouts.pagination', array('pages' => $pages)); ?>
