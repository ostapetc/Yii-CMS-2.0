<?
$this->tabs = array(
    'Добавить страницу' => $this->createUrl('create')
);

$urls   = array();
$params = $_GET;
foreach (YouTubeApiCriteria::$order_list as $sort => $label)
{
    $params['sort'] = $sort;
    $key            = $this->createUrl('', $params);
    $urls[$key]     = $label;
}
$selected = isset($_GET['sort']) ? $_GET['sort'] : YouTubeApiCriteria::ORDER_VIEW_COUNT;
$filter = CHtml::textField('tyoutube-search');
$sorter   = 'Сортировать по: ' . CHtml::dropDownList('order', $selected, $urls, array(
    'id' => 'youtube-sorter',
));
/*
$widget = $this->widget('AdminListView', array(
    'itemView' => '_manage',
    'dataProvider' => $model->search(),
    'template' => $sorter . "{pager}\n{sorter}\n{items}\n{pager}",
    'pager' => array(
        'class' => 'AdminLinkPager',
        'no_end' => true
    )
));
*/

$widget = $this->widget('AdminGridView', array(
    'id'           => 'youtube-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'template'     => $sorter . '{pagerSelect}{summary}<br/>{items}{pager}',
    'columns'      => array(
        array(
            'value' => '"<iframe src=".$data->player_url."></iframe>"',
            'type'  => 'raw'
        ),
        array(
            'name' => 'title',
            'type' => 'raw'
        ),
        array(
            'header' => 'Рейтинги',
            'value'  => '"Показы: ".$data->view_count."<br/>Проголосовало: ".$data->raters."<br/>Рейтинг: ".$data->average',
            'type'   => 'raw'
        ),
        array(
            'header' => 'Автор',
            'name'   => 'author',
            'value'  => 'CHtml::link($data->author, $data->author_uri, array("target"=>"_blank"))',
            'type'   => 'raw'
        ),
        array(
            'header' => 'Категория',
            'name'   => 'category',
        ),
    ),
));
?>


<script type="text/javascript">
    $(document).ready(function()
    {
        $('body').delegate('#youtube-sorter', 'change', function()
        {
            $('#modal_<?=$widget->getId()?>').yiiListView('update', {url: $(this).val()});
        });
    });

</script>
