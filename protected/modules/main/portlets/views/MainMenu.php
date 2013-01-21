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
                    'items' => $items
                ))
                ?>
                <form action="<?= $this->createUrl('/content/search/index') ?>" class="navbar-search pull-left">
                    <input type="text" placeholder="Поиск" name="q" value="<?= $query ?>" class="search-query span2" style="width: 223px">
                </form>
                <? $this->render('_MenuRight') ?>
            </div>
        </div>
    </div>
</div>


