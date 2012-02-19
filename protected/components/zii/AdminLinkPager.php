<?php

class AdminLinkPager extends BootPager
{

    public $displayFirstAndLast = true;

    public $cssFile = false;

    public $lastPageLabel = 'Конец';
    public $firstPageLabel = 'Начало';
    public $prevPageLabel = '←';
    public $nextPageLabel = '→';

    public $header = '';

}