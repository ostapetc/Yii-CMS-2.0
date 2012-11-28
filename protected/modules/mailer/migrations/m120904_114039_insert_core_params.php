<?php

class m120904_114039_insert_core_params extends DbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `params`
                (`module_id`, `code`, `name`, `value`, `element`, `options`) VALUES
                ('users', 'registration_done_message', 'Сообщение о завершении регистрации', '<p>Вы успешно зарегистрированы в системе, на ваш Email отправлено письмо с инструкциями завершения регистрации.</p>', 'editor', NULL);

        ");
	}


	public function down()
	{
		echo "m120904_114039_insert_core_params does not support migration down.\n";
		return false;
	}
}