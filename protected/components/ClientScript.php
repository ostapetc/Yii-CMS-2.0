<?php
class ClientScript extends CClientScript
{
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
            $output = $scripts . "\n" . $_GET['callback'] . '({ content : "' . addslashes($output) . '" })';
        }
        else
        {
            parent::render($output);
        }
    }
}