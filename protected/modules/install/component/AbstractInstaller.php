<?php
abstract class AbstractInstaller extends CComponent
{
    public function getRequirements()
    {
        return array(
            'PHP' => array(
                'is_support'      => version_compare(phpversion(), '5.3', '>'),
                'version'         => phpversion(),
                'minimal_version' => '5.3',
            ),
            'Reflection' => array(
                'is_support'      => class_exists('Reflection', false),
            ),
            'SPL' => array(
                'is_support'      => extension_loaded("SPL"),
            ),
            'DOMDocument' => array(
                'is_support'      => class_exists("DOMDocument", false),
            ),
            'mcrypt' => array(
                'is_support'      => extension_loaded("mcrypt"),
            ),
            'soap' => array(
                'is_support'      => extension_loaded("soap"),
            ),
        );
    }

    abstract public function initDataBase($configuration);
    abstract public function initUsers();

    /**
     * parse file and
     *
     * @static
     * @param $source
     * @param $target
     * @param $data
     */
    public function parseFile($source, $target, $data)
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
    public function parseConfig($file, $data)
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
    public function createDb(Step1 $model)
    {
        set_error_handler(array('InstallHelper', 'pdoErrorHandler'));
        try
        {
            $connection = new CDbConnection('mysql:host='.$model->db_host.';', $model->db_login, $model->db_pass);
            //set collate for unify
            $sql = "CREATE DATABASE IF NOT EXISTS `{$model->db_name}` CHARACTER SET utf8 COLLATE utf8_general_ci";
            //$this->execute() do echo some information for console. it needn't
            $connection->createCommand($sql)->execute();
            $return = !self::$pdo_error_happend;
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