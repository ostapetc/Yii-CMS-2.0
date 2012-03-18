<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->meta_title; ?></title>

<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<!--стили сайта-->
<?php
Yii::app()->bootstrap->init();
$assets = Yii::app()->getModule('docs')->assetsUrl();
Yii::app()->clientScript->registerCssFile($assets . '/css/styles.css');
?>

</head>
<body>
<?php
$items = array();
$i = new RecursiveDirectoryIterator(Yii::getPathOfAlias('docs.views.documentation'));

for ($i->rewind(); $i->valid(); $i->next())
{
    $item=$i->current();
    if (!$i->hasChildren())
    {
        continue;
    }
    $folder_name = t($item->getFileName());
    $active_folder = false;
    $tmp = array();
    foreach ($i->getChildren() as $child)
    {
        list($file) = explode('.',$child->getFileName());
        $active = isset($_GET['alias']) && ($_GET['alias'] == $file) ? true : false;
        $active_folder = $active_folder || $active;
        $tmp[] = array(
            'label'       => t($file),
            'itemOptions' => array(),
            'active'      => $active,
            'url'         => Yii::app()->createUrl('/docs/documentation/index', array('alias'=>$file, 'folder'=>$item->getFileName()))
        );
    }
    if ($active_folder)
    {
        $items[] = array(
            'label'       => $folder_name,
            'itemOptions' => array('class'=> 'nav-header'),
        );
        $items = array_merge($items, $tmp);
    }
    else
    {
        $items[] = array(
            'label'       => $folder_name,
            'items'       => $tmp,
            'itemOptions' => array('class'=> 'nav-header'),
        );
    }
}

//foreach (Documentation::model()->orderByLft()->findAll() as $doc)
//{
//    if ($doc->depth == 1)
//    {
//        continue;
//    }
//    $tmp = array(
//        'label'       => $doc->title,
//        'itemOptions' => $doc->depth > 2 ? array() : array('class'=> 'nav-header'),
//        'active'      => isset($_GET['alias']) && ($_GET['alias'] == $doc->alias) ? true : false,
//    );
//    if ($doc->depth > 2)
//    {
//        $tmp['url'] = $doc->href;
//    }
//    $items[] = $tmp;
//}

?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">

            <a class="brand" href="/">Yii-CMS 2.0</a>

            <div class="nav-collapse">
                <ul class="nav pull-right">
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav sidebar">
                <?php
                $this->widget('BootMenu', array(
                    'items'       => $items,
                    'type' => BootMenu::TYPE_LIST,
                    'htmlOptions' => array(
                        'id'   => 'sidebar-docs-menu'
                    )
                )) ?>
            </div>
        </div>
        <div class="span9 center content">
            <?php echo $content ?>
        </div>
    </div>
</div>


</body>
</html>
