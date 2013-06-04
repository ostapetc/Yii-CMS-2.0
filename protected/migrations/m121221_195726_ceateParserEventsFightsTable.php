<?php

class m121221_195726_ceateParserEventsFightsTable extends DbMigration
{
	public function up()
	{
        $this->createTable('parser_events_fights', array(
            'id'            => 'pk',
            'event_id'      => 'integer NOT NULL',
            'fighter_a_id'  => 'integer NOT NULL',
            'fighter_b_id'  => 'integer NOT NULL',
            'referee'       => 'string',
            'method'        => 'string',
            'round'         => 'string',
            'time'          => 'string'
        ));
	}


	public function down()
	{
        $this->dropTable('parser_events_fights');
	}
}