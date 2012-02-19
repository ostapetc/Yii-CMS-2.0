<?php
$this->page_title = $this->t('admin', 'manage');

$this->widget('AdminGridView', array(
    'id'           => 'news-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'title', array(
            'name'  => 'user_id',
            'value' => '$data->user->name'
        ), array(
            'name'  => 'is_published',
            'value' => '$data->is_published ? t("yes") : t("no")',
            'filter'=>array(t("Нет"),t("Да"))
        ),
        array(
            'class'=>'DateColumn',
            'name'=>'date'
        ), array(
            'name'  => 'lang',
            'value' => '$data->language->name'
        ), array(
            'class'=> 'CButtonColumn',
        ),
    ),
));
