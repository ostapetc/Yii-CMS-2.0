<?php

class m121221_180959_createParserFightersTable extends DbMigration
{
	public function up()
	{
	    $this->createTable('parser_fighters', array(
            'id'               => 'pk',
            'name'             => 'string NULL',
            'nickname'         => 'string NULL',
            'birthdate'        => 'string NULL',
            'city'             => 'string NULL',
            'height'           => 'string NULL',
            'weight'           => 'string NULL',
            'class'            => 'string NULL',
            'association'      => 'string NULL',
            'wins'             => 'string NULL',
            'losses'           => 'string NULL',
            'win_ko'           => 'string NULL',
            'win_submissions'  => 'string NULL',
            'win_decisions'    => 'string NULL',
            'loss_ko'          => 'string NULL',
            'loss_submissions' => 'string NULL',
            'loss_decisions'   => 'string NULL',
            'image'            => 'string NULL',
            'date_update'      => 'integer'
        ));
    }


	public function down()
	{
        $this->dropTable('parser_fighters');
	}
}