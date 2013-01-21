<?php

class m121221_195453_ceateParseEventsTable extends DbMigration
{
	public function up()
	{
        $this->createTable('parser_events', array(
            'id'   => 'pk',
            'name' => 'string',
            'date' => 'string',
            'href' => 'string',
        ));
	}


	public function down()
	{
        $this->dropTable('parser_events');
	}
}