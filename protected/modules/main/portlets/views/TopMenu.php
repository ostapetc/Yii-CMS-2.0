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

<ul class="nav" id="top-menu">
    <li class="divider-vertical"></li>
    <li>
        <form class="navbar-search pull-left" action="<? echo Yii::app()->createUrl('/search'); ?>">
            <input type="text" class="search-query" placeholder="<?=t('Поиск') ?>"  name="query" value="<? echo $query; ?>">
        </form>
    </li>
    <li class="divider-vertical"></li>

    <? Yii::app()->controller->renderPartial('application.modules.users.views.user._authBox') ?>


    <? if (Yii::app()->params->multilanguage_support): ?>
        <li class="divider-vertical"></li>
        <li class="languages_li">
            <? $this->widget('LanguageSwitcher') ?>
        </li>
    <? endif ?>
</ul>