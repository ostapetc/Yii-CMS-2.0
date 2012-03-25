<?

Yii::import('zii.widgets.grid.CGridView');
Yii::import('ext.GridMail.CGridMailColumn');

class GridMail extends CGridView
{

    public $trStyleOdd;
    public $trheadStyle;
    public $tdbodyStyle;
    public $tableStyle;
    public $trStyleEven;
    public $summaryStyle;
    public $theadStyle;
    public $tbodyStyle;
    public $tfootStyle;
    public $tfootTrStyle;
    public $theadThStyle;
    public $template = "{items}\n{summary}";


    public function init()
    {
        $this->dataProvider->pagination = false;
        parent::init();
        $this->baseScriptUrl = null;
        $this->cssFile       = false;
    }


    public function renderKeys()
    {
        return;
    }

    /**
     * Registers necessary client scripts.
     */
    public function registerClientScript()
    {
        return;
    }

    public function renderSummary()
    {
        if (!($this->summaryText)) {
            return;
        }

        $data = $this->dataProvider->getData();
        $n    = count($data);
        if (!$n) {
            return;
        }

        $totalSum = 0;
        for ($row = 0; $row < $n; ++$row)
        {
            $data = $this->dataProvider->data[$row];
            $totalSum += $data->quantity * $data->price;
        }
        echo "<div style=\"{$this->summaryStyle}\">";
        echo strtr($this->summaryText, array(
            '{count}'   => $n,
            '{totalSum}'=> $totalSum,
        ));
        echo '</div>';
    }


    /**
     * Renders the data items for the grid view.
     */
    public function renderItems()
    {
        if ($this->dataProvider->getItemCount() > 0 || $this->showTableOnEmpty)
        {
            echo "<table style=\"border-collapse:collapse;{$this->tableStyle}\" cellpadding=\"0\" cellspacing=\"0\">";

            $this->renderTableHeader();
            ob_start();
            $this->renderTableBody();
            $body = ob_get_clean();
            $this->renderTableFooter();
            echo $body; // TFOOT must appear before TBODY according to the standard.
            echo "</table>";
        }
        else
        {
            $this->renderEmptyText();
        }
    }

    /**
     * Renders the table header.
     */
    public function renderTableHeader()
    {
        if (!$this->hideHeader)
        {
            echo "<thead style=\"{$this->theadStyle}\">\n";
            echo "<tr style=\"{$this->trheadStyle}\">";

            foreach ($this->columns as $column)
            {
                ob_start();
                $column->renderHeaderCell();
                $content = ob_get_clean();
                $content = preg_replace('#<a.*?>(.*?)</a>#sm', '$1', $content);
                $content = preg_replace('#<th[^>]*>#m', '<th style="' . $this->theadThStyle . '">', $content);
                echo $content;
            }
            echo "</tr>\n";

            if ($this->filterPosition === self::FILTER_POS_BODY) {
                $this->renderFilter();
            }

            echo "</thead>\n";
        }
        else if ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER ||
            $this->filterPosition === self::FILTER_POS_BODY)
        )
        {
            echo "<thead>\n";

            $this->renderFilter();
            echo "</thead>\n";
        }
    }

    /**
     * Renders the filter.
     *
     * @since 1.1.1
     */
    public function renderFilter()
    {
        if ($this->filter !== null)
        {
            echo "<tr style=\"{$this->_trStyle}\">";

            foreach ($this->columns as $column) {
                $column->renderFilterCell();
            }
            echo "</tr>\n";
        }
    }

    /**
     * Renders the table footer.
     */
    public function renderTableFooter()
    {
        $hasFooter = $this->getHasFooter();
        if ($hasFooter)
        {
            echo "<tfoot style=\"{$this->tfootStyle}\">\n";
            echo "<tr style=\"{$this->tfootTrStyle}\">";
            foreach ($this->columns as $column) {
                $column->renderFooterCell();
            }
            echo "</tr>\n";
            echo "</tfoot>\n";
        }
    }

    /**
     * Renders the table body.
     */
    public function renderTableBody()
    {
        $data = $this->dataProvider->getData();
        $n    = count($data);


        echo "<tbody>\n";

        if ($n > 0)
        {
            for ($row = 0; $row < $n; ++$row) {
                $this->renderTableRow($row);
            }
        }
        else
        {
            echo "<tr style=\"{$this->trheadStyle}\"><td colspan=\"" . count($this->columns) . "\">";

            $this->renderEmptyText();
            echo "</td></tr>\n";
        }
        echo "</tbody>\n";
    }

    /**
     * Renders a table body row.
     *
     * @param integer $row the row number (zero-based).
     */
    public function renderTableRow($row)
    {
        echo '<tr style="' . (($row % 2) ? $this->trStyleOdd : $this->trStyleEven) . '">';
        foreach ($this->columns as $column)
        {
            ob_start();
            $column->renderDataCell($row);
            $content = ob_get_clean();
            $content = preg_replace('#<td[^>]*>#m', '<td style="' . $this->tdbodyStyle . '">', $content);
            echo $content;

        }
        echo "</tr>\n";
    }

    /**
     * @return boolean whether the table should render a footer.
     * This is true if any of the {@link columns} has a true {@link CGridColumn::hasFooter} value.
     */
    public function getHasFooter()
    {
        foreach ($this->columns as $column)
        {
            if ($column->getHasFooter())
            {
                return true;
            }
        }
        return false;
    }

}


