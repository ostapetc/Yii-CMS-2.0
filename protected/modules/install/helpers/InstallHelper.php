<?php
class InstallHelper
{
    public static function parseFile($source, $target, $data)
    {
       $content = strtr(file_get_contents($source), $data);
       copy ($source, $target);
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
       $source = Yii::getPathOfAlias('install.views.templates.'.$file).'.php';
       $target = Yii::getPathOfAlias('application.config.'.$file).'.php';
       self::parseFile($source, $target, $data);
    }

    /**
     * create dbI if no exists
     *
     * @static
     * @param Step1 $model
     * @return bool|string true or error message
     */
    public static function createDb(Step1 $model)
    {
        set_error_handler(array('InstallHelper', 'pdoErrorHandler'));
        try
        {
            $connection = new CDbConnection('mysql:host='.$model->db_host.';', $model->db_login, $model->db_pass);
            //set collate for unify
            $sql = "CREATE DATABASE IF NOT EXISTS `{$model->db_name}` CHARACTER SET utf8 COLLATE utf8_general_ci";
            //$this->execute() do echo some information for console. it needn't
            $connection->createCommand($sql)->execute();
            $return = true;
        }
        catch(Exception $e)
        {
            $return = $e->getMessage();
        }
        restore_error_handler();
        return $return;
    }

    public static $pdo_error_happend;

    public function pdoErrorHandler($code, $message, $file, $line)
    {
        if (!self::$pdo_error_happend)
        {
            self::$pdo_error_happend = true;
            Yii::app()->handleError($code, 'Невозможно подключиться к базе данных по указанным параметрам', $file, $line);
        }
    }

}