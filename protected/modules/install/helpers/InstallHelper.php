<?php
class InstallHelper
{
    /**
     * parse file and
     *
     * @static
     * @param $source
     * @param $target
     * @param $data
     */
    public static function parseFile($source, $target, $data)
    {
        $formatted_data = array();
        foreach ($data as $key => $val)
        {
            $formatted_data['{{'.$key.'}}'] = $val;
        }
        $content = strtr(file_get_contents($source), $formatted_data);
        file_put_contents($target, $content);
    }

    /**
     * parse config file and rebase it from install.view.templates to application.config folder
     *
     * @static
     * @param $file
     * @param $data
     */
    public static function parseConfig($file, $data)
    {
        $source = Yii::getPathOfAlias('application.config.'.$file).'.php.tpl';
        $target = Yii::getPathOfAlias('application.config.'.$file).'.php';
        self::parseFile($source, $target, $data);
    }
}