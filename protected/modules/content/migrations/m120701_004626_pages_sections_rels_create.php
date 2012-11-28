<?
class m120701_004626_pages_sections_rels_create extends DbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `pages_sections_rels` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `page_id` int(11) unsigned NOT NULL,
                `section_id` int(11) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                KEY `page_id` (`page_id`),
                KEY `section_id` (`section_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            ALTER TABLE `pages_sections_rels`
                ADD CONSTRAINT `page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `section` FOREIGN KEY (`section_id`) REFERENCES `pages_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");
    }


    public function down()
    {
        $this->execute("DROP TABLE `pages_sections_rels`");
    }
}