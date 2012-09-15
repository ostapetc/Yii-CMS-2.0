<?php

class m120912_174125_insert_pages_sections_rels extends DbMigration
{
	public function up()
	{
	    $this->execute("
            INSERT INTO `pages_sections_rels` (`id`, `page_id`, `section_id`) VALUES
            (27, 3, 1),
            (32, 4, 1),
            (34, 6, 2),
            (36, 5, 1),
            (39, 7, 1),
            (42, 8, 2);
	    ");
    }


	public function down()
	{
		echo "m120912_174125_insert_pages_sections_rels does not support migration down.\n";
		return false;
	}
}