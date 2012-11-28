<h4><?= t('Фильтр') ?></h4>

<?= CHtml::beginForm('/' . Yii::app()->request->pathInfo, 'get', array('class' => 'sidebar-form')) ?>
<?= CHtml::textField('User[name]', $model->name, array('placeholder' => $model->getAttributeLabel('name'))) ?>
<?= CHtml::textField('User[email]', $model->email, array('placeholder' => $model->getAttributeLabel('email'))) ?>
<?= CHtml::submitButton(t('фильтровать'), array('class' => 'btn')) ?>
<?= CHtml::endForm();



