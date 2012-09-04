<?php

class m120904_113455_insert_core_templates extends DbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `mailer_templates` (`code`, `name`, `subject`) VALUES
            ('user_activation', 'Активация аккаунта', 'Активация аккаунта на сайте {{PROJECT_NAME}}'),
            ('user_registration', 'Регистрация пользователя', 'Вы зарегистрировались на сайте {{PROJECT_NAME}}'),
            ('user_change_password ', 'Восстановление пароля', 'Восстановление пароля на сайте {{PROJECT_NAME}}');
        ");
	}


	public function down()
	{
		echo "m120904_113455_insert_core_templates does not support migration down.\n";
		return false;
	}
}