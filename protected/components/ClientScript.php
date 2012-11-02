<?php
class ClientScript extends CClientScript
{

    /**
     * add JSONP-supporting functionality
     * using: $.getJSON('url?callback=?', function(html) {alert(html);});
     * see(http://api.jquery.com/jQuery.getJSON/#jsonp)
     * all registered scripts (non file) will evaluate on client automatically
     *
     * @param string $output
     */
    public function render(&$output)
    {
        if (Yii::app()->request->getIsAjaxRequest() && isset($_GET['callback']))
        {
            $scripts = '';
            foreach ($this->scripts as $pos)
            {
                foreach ($pos as $script)
                {
                    $scripts .= $script;
                }
            }
            $output = $scripts . "\n" . $_GET['callback'] . '("' . addslashes($output) . '")';
        }
        else
        {
            parent::render($output);
        }
    }
}