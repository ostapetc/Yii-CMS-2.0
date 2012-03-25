<script type="text/javascript">
    $(function() {
        var $search_query = $('.search-query');

        checkQueryLength();

        $search_query.change(checkQueryLength);
        $search_query.keyup(checkQueryLength);


        function checkQueryLength()
        {
            var length = $search_query.val().length;

            if (length != 0 && length < 3)
            {
                $search_query.addClass('error-text');
            }
            else
            {
                $search_query.removeClass('error-text');
            }
        }
    });
</script>

<?
$query = "";
if (isset($_GET['query']))
{
    $query = trim(strip_tags($_GET['query']));
}
?>

<ul class="nav">
    <? if ($sections): ?>
        <? foreach ($sections as $section): ?>
            <?
            $class  = $section->isActive() ? 'active' : '';
            $childs = $section->children()->findAll();
            ?>

            <? if ($childs): ?>
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><? echo $section->title; ?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <? foreach ($childs as $child): ?>
                        <li><a href="<? echo $child->href; ?>"><? echo $child->title; ?></a></li>
                    <? endforeach ?>
                </ul>
            <? else: ?>
                <li class="<? echo $class; ?>"><a href="<? echo $section->href; ?>"><? echo $section->title; ?></a></li>
            <? endif ?>


        <? endforeach ?>
    <? endif ?>

    <li class="divider-vertical"></li>
    <li>
        <form class="navbar-search pull-left" action="<? echo Yii::app()->createUrl('/search'); ?>">
            <input type="text" class="search-query" placeholder="<?=t('Поиск') ?>"  name="query" value="<? echo $query; ?>">
        </form>
    </li>
    <li class="divider-vertical"></li>
<!--    <li style="padding-right: 0 !important;">-->
<!--        <a href="/ru" style="padding-right: 0 !important;"><img src="/img/icons/ru.png" /></a>-->
<!--    </li>-->
<!--    <li>-->
<!--        <a href="/en"><img src="/img/icons/en.png" /></a>-->
<!--    </li>-->
</ul>