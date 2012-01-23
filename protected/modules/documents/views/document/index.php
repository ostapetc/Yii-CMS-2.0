<?php $this->page_title = Yii::t('DocumentsModule.main', 'Уставные документы'); ?>

<?php $this->renderPartial('_list', array('documents' => $documents)); ?>

<?php $this->renderPartial('application.views.layouts.pagination', array('pages' => $pages)); ?>
