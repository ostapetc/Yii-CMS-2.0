<?

class AdminLinkPager extends BootPager
{

    public $displayFirstAndLast = true;

    public $cssFile = false;

    public $lastPageLabel = 'Конец';
    public $firstPageLabel = 'Начало';
    public $prevPageLabel = '←';
    public $nextPageLabel = '→';

    public $header = '';

    public $maxButtonCount = 7;

    public function createPageButtons()
    {
        if (($pageCount = $this->getPageCount()) <= 1)
        {
            return array();
        }

        list ($beginPage, $endPage) = $rangePage = $this->getPageRange();

        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()

        $buttons = array();

        // first page
        if ($this->displayFirstAndLast)
        {
            $buttons[] = $this->createPageButton($this->firstPageLabel, 0, 'first', $currentPage <= 0, false);
        }

        // prev page
        if (($page = $currentPage - 1) < 0)
        {
            $page = 0;
        }

        $buttons[] = $this->createPageButton($this->prevPageLabel, $page, 'previous',
            $currentPage <= 0, false);


        // ... in begin
        if ($rangePage[0] + 1 != 1)
        {
            $buttons[] = $this->createPageButton('1', 0, self::CSS_FIRST_PAGE, $currentPage <= 0, false);
            if ($rangePage[0] + 1 > 2)
            {
                $buttons[] = $this->createPageButton('...', $rangePage[0] - 1, 'page disabled', false, false);
            }
        }


        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i)
        {
            $buttons[] = $this->createPageButton(
                $i + 1, $i, self::CSS_INTERNAL_PAGE, false, $i == $currentPage);
        }


        // ... in end
        if ($rangePage[1] + 1 != $this->pages->pageCount)
        {
            if ($rangePage[1] + 1 != $this->pages->pageCount - 1)
            {
                $buttons[] = $this->createPageButton('...', $rangePage[1] + 1, 'page disabled', false, false);
            }
            $buttons[] = $this->createPageButton($this->pages->pageCount, $pageCount - 1, self::CSS_LAST_PAGE,
                $currentPage >= $pageCount - 1, false);
        }


        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1)
        {
            $page = $pageCount - 1;
        }

        $buttons[] = $this->createPageButton($this->nextPageLabel, $page, 'next',
            $currentPage >= ($pageCount - 1), false);

        // last page
        if ($this->displayFirstAndLast)
        {
            $buttons[] = $this->createPageButton($this->lastPageLabel, $pageCount - 1, 'last',
                $currentPage >= ($pageCount - 1), false);
        }

        return $buttons;
    }
}