<?php
abstract class ContentParserAbstract extends CComponent
{
    public function init()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);
    }


    abstract public function parse();

}
