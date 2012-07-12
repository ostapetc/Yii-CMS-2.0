<?
class m120701_004626_pages_sections_rels_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `pages_sections_rels`");

        $this->execute("
            CREATE TABLE `pages_sections_rels` (
                `id` int(11) unsigned NOT NULL,
                `page_id` int(11) unsigned NOT NULL,
                `section_id` int(11) unsigned NOT NULL,
                KEY `page_id` (`page_id`),
                KEY `section_id` (`section_id`),
                CONSTRAINT `pages_sections_rels_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `pages_sections_rels_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `pages_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}