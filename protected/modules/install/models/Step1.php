<?php
class Step1 extends AbstractInstallModel
{
    public $db_host = 'localhost';
    public $db_login;
    public $db_pass;
    public $db_name;

    public function rules()
    {
        return array(
            array('db_host', 'required'),
            array('db_name', 'required'),
            array('db_login', 'required'),
            array('db_pass', 'safe',),
        );
    }

    public function attributeLabels()
    {
        return array(
            'db_host'            => 'Хост базы данных',
            'db_name'            => 'Имя базы данных',
            'db_login'           => 'Логин базы данных',
            'db_pass'            => 'Пароль к базе данных',
            'db_pass_confirm'    => 'Пароль к базе данных, подтверждение',
        );
    }

    public function getDbPatterns()
    {
        return array('%DB_HOST%' => $this->db_host, '%DB_PASS%' => $this->db_pass, '%DB_LOGIN%' => $this->db_login, '%DB_NAME%' => $this->db_name);
    }

    public function createDbConnection($db_must_exists = true)
    {
        $conn_string = 'mysql:host=' . $this->db_host . ';' . ($db_must_exists ? 'dbname=' . $this->db_name : '');
        $con = new CDbConnection($conn_string, $this->db_login, $this->db_pass);
        $con->init();
        return $con;
    }

    /**
     * create dbI if no exists
     *
     * @static
     * @param Step1 $model
     * @return bool|string true or error message
     */
    public function createDb()
    {
        set_error_handler(array($this, 'pdoErrorHandler'));
        try
        {
            $db = $this->createDbConnection(false);
            //set collate for unify
            $sql = "CREATE DATABASE IF NOT EXISTS `{$this->db_name}` CHARACTER SET utf8 COLLATE utf8_general_ci";
            //$this->execute() do echo some information for console. it needn't
            $db->createCommand($sql)->execute();
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

    public function getConfigs()
    {
        return array(
            'development' => $this->getDbPatterns(),
            'production' => array()
        );
    }
}