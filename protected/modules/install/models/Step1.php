<?php
class Step1 extends FormModel
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

}