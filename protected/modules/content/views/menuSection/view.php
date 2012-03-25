<?
if (isset($section) && $section)
{
    $crumbs = array();

    if ($section->parent)
    {
        $crumbs[$section->parent->title] = $section->parent->href;
    }
    $crumbs[$section->title] = $section->href;
}
else
{
    $crumbs[$section->title] = "";
}

$this->crumbs     = $crumbs;
$this->page_title = $section->title;


if (count($children) > 1)
{
    ?>
<div class="news">
    <ul>
        <?
        foreach ($children as $child)
        {
            echo CHtml::tag('li', array(), CHtml::link($child->title, $child->href));
        }
        ?>
    </ul>
</div>
<?
}
elseif (count($children) == 1)
{
    $this->redirect($children[0]->href);
}
else
{
    echo CHtml::tag('div', array(), 'Данная категория пуста');
}


