<?php
require_once 'DGSphinxSearch.php';
require_once 'SphinxDataProvider.php';

class SphinxSearch extends DGSphinxSearch
{
    public $matchMode = SPH_MATCH_EXTENDED2;
    public $port = 9312;


}