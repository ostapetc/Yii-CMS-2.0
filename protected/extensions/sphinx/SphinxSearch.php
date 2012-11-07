<?php
require_once 'DGSphinxSearch.php';
require_once 'SphinxDataProvider.php';

class SphinxSearch extends DGSphinxSearch
{
    public $matchMode = SPH_MATCH_EXTENDED2;
    public $port = 9312;


    public function setFullText($str)
    {
        $this->SetMatchMode(SPH_MATCH_EXTENDED2);
        $this->SetRankingMode(SPH_RANK_SPH04);
//        $search->SetSortMode(SPH_SORT_RELEVANCE);
        $str = strtr($str, [
            '"' => '\"',
            '/' => '\/'
        ]);
        $this->where($str);
        return $this;
    }


    public function setLastCriteria()
    {
        $this->setCriteria($this->lastCriteria);
        return $this;
    }


    protected function initIterator(array $data, $criteria = NULL)
    {
        return new SphinxDataProvider($data);
    }


}
