<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a href="/" class="brand">Martial Arts</a>
            <div class="nav-collapse">
                <?
                $this->widget('ClientMenu', array(
                    'items'       => $items
                ))
                ?>
                <form action="" class="navbar-search pull-left">
                    <input type="text" placeholder="Поиск" value="<?= $query ?>" class="search-query span2">
                </form>
                <? $this->render('_MenuRight') ?>
            </div>
        </div>
    </div>
</div>


