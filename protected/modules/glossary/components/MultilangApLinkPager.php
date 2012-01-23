<?php
class MultilangApLinkPager extends ApLinkPager
{
    protected function createPageButtons()
    {
        $buttons           = array();
        $labels_comp       = $labels = $this->pages->getCharSet();
        $activeLabels_comp = $activeLabels = $this->pages->getActiveCharSet();
        $labelCount        = count($labels);
        $currentPage       = $this->getCurrentPage(false);

        // show-numeric page
        if ($this->showNumPage)
        {
            $buttons[] = $this->createPageButton($this->numPageLabel, 0, self::CSS_ALL_PAGE, !$this->pages->activeNumbers,
                0 == $currentPage);
        }

        if ($this->pages->forceCaseInsensitive === true)
        {
            // convert all labels (characters) to lower case for case insensitive comparison
            $labels_comp       = array_map('strtolower', $labels);
            $activeLabels_comp = array_map('strtolower', $activeLabels);
        }


        // internal pages
        for ($i            = 0; $i < $labelCount; ++$i)
        {
            $label = $labels[$i];
            $comp  = $labels_comp[$i];
            if ($label === 'LANG_END')
            {
                $buttons[] = '<br/>';
                continue;
            }
            $buttons[] = $this->createPageButton($label,
                $i + 1, self::CSS_INTERNAL_PAGE, !in_array($comp, $activeLabels_comp), $i + 1 == $currentPage);
        }


        // show-all page
        if ($this->showAllPage)
        {
            $buttons[] = $this->createPageButton($this->allPageLabel, -1, self::CSS_ALL_PAGE, !count($activeLabels) > 0,
                -1 == $currentPage);
        }

        return $buttons;
    }

}