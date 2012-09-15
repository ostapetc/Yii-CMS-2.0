<?php

class m120912_174745_insert_tags_rels extends DbMigration
{
	public function up()
	{
	    $this->execute("
            INSERT INTO `tags_rels` (`id`, `tag_id`, `object_id`, `model_id`) VALUES
            (1, 1, 1, 'Page'),
            (2, 2, 1, 'Page'),
            (3, 3, 1, 'Page'),
            (4, 4, 3, 'Page'),
            (11, 4, 4, 'Page'),
            (5, 5, 3, 'Page'),
            (10, 5, 4, 'Page'),
            (12, 6, 6, 'Page'),
            (13, 7, 6, 'Page'),
            (14, 8, 6, 'Page'),
            (15, 9, 6, 'Page'),
            (16, 10, 6, 'Page'),
            (17, 11, 5, 'Page'),
            (18, 12, 5, 'Page'),
            (19, 13, 5, 'Page'),
            (20, 14, 7, 'Page'),
            (21, 15, 7, 'Page'),
            (22, 16, 7, 'Page'),
            (23, 16, 8, 'Page'),
            (24, 17, 8, 'Page'),
            (25, 18, 8, 'Page'),
            (26, 19, 8, 'Page'),
            (27, 21, 8, 'Page');
	    ");
    }


	public function down()
	{
		echo "m120912_174745_insert_tags_rels does not support migration down.\n";
		return false;
	}
}