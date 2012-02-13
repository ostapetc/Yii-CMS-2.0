<?php

$this->page_title = 'Языковые переводы';

$columns = array('message');

foreach ($languages as $id => $language)
{
    $columns[] = array(
        'header' => $language,
        'value'  => '$data->translation("'. $id .'")'
    );
}

$columns[] = array('class' => 'CButtonColumn');
?>

<script type="text/javascript">
//    $(function() {
//        $('.pills').dropdown();
//    });
</script>

<ul class="nav pills" data-toggle="dropdown">
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
$this->widget('AdminGridView', array(
	'id'           => 'languages-translations-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns'      => $columns
));