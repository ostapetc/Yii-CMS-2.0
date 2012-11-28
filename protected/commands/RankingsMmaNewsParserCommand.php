<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 27.11.12
 * Time: 18:12
 * To change this template use File | Settings | File Templates.
 */

class RankingsMmaNewsParserCommand
{
    public function run($args)
    {
        require_once APP_PATH . 'extensions/phpQuery.php';

        $doc  = phpQuery::newDocumentFile('http://www.mmanews.com/rankings');
        $divs = $doc->find('div.float_l, div.float_r');

        foreach ($divs as $div)
        {
            $div = pq($div);

            $title = $div->find('.ranking_header:eq(0)')->html();
            echo $title . "<br/>";

            $rows = $div->find('.ranking_rows');
            foreach ($rows as $row)
            {
                $row = pq($row);
                echo $row->html() . "<br/>";
            }
        }
    }
}
