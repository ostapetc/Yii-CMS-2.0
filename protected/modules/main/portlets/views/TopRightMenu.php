<script type="text/javascript">
    $(function () {
        var $search_query = $('.search-query');

        checkQueryLength();

        $search_query.change(checkQueryLength);
        $search_query.keyup(checkQueryLength);


        function checkQueryLength() {
            var length = $search_query.val().length;

            if (length != 0 && length < 3) {
                $search_query.addClass('error-text');
            }
            else {
                $search_query.removeClass('error-text');
            }
        }
    });
</script>

<?
$this->widget('BootMenu', array(
    'encodeLabel' => false,
    'htmlOptions' => array(
        'class' => 'top-right-menu'
    ),
    'items' => $items
));
?>

<!--<form class="navbar-search pull-left" action="--><?// echo Yii::app()->createUrl('/search'); ?><!--">-->
<!--    <input type="text" class="search-query" placeholder="--><?//=t('Поиск') ?><!--" name="query" value="--><?// echo $query; ?><!--">-->
<!--</form>-->



<!--<ul class="nav" class="top-right-menu">-->
<!--    <li class="divider-vertical"></li>-->
<!--    <li>-->
<!--        <form class="navbar-search pull-left" action="--><?// echo Yii::app()->createUrl('/search'); ?><!--">-->
<!--            <input type="text" class="search-query" placeholder="--><?//=t('Поиск') ?><!--" name="query" value="--><?// echo $query; ?><!--">-->
<!--        </form>-->
<!--    </li>-->
<!---->
<!--    <li class="divider-vertical"></li>-->
<!---->
<!--    --><?// if (Yii::app()->user->isGuest): ?>
<!--        <li>-->
<!--            --><?//= CHtml::link('Войти', '/login?redirect=' . $_SERVER['REQUEST_URI'], array('class' => 'show-modal-link', 'data-modal-id' => 'login-modal')); ?>
<!--        </li>-->
<!--        <li>-->
<!--            --><?//= CHtml::link('Регистрация', '/registration', array('class' => 'show-modal-link', 'data-modal-id' => 'registration-modal')); ?>
<!--        </li>-->
<!--    --><?// else: ?>
<!--        <li>-->
<!--            --><?//= Yii::app()->user->model->getLink(array('class' => 'user-link')); ?>
<!--        </li>-->
<!--        <li>-->
<!--            --><?//= CHtml::link('выйти', '/users/user/logout'); ?><!--</li>-->
<!--        <li style="padding-top: 9px">-->
<!--            --><?//= Yii::app()->user->model->photo_link ?>
<!--        </li>-->
<!--    --><?// endif ?>
<!---->
<!--    --><?// if (Yii::app()->params->multilanguage_support): ?>
<!--        <li class="divider-vertical"></li>-->
<!--        <li class="languages_li">-->
<!--            --><?// $this->widget('LanguageSwitcher') ?>
<!--        </li>-->
<!--    --><?// endif ?>
<!--</ul>-->
<!---->



