<ul class="nav pills">
    <li class="active"><a href="#">Regular link</a></li>
    <li class="dropdown" id="menu1">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">
            Dropdown
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
        </ul>
    </li>
</ul>

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
        ), array('name'  => 'state',
                 'value' => 'News::$states[$data->state]'
        ), 'date', 'date_create', array('name'  => 'lang',
                                        'value' => '$data->language->name'
        ), array(
            'class'=> 'CButtonColumn',
        ),
    ),
));
?>
