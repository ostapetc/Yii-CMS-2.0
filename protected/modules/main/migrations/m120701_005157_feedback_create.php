<?
class m120701_005157_feedback_create extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `feedback`");

        $this->execute("
            CREATE TABLE `feedback` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `topic_id` int(11) unsigned NOT NULL COMMENT 'Тема',
                `name` varchar(200) NOT NULL COMMENT 'Имя',
                `email` varchar(200) NOT NULL COMMENT 'Email',
                `text` text NOT NULL COMMENT 'Текст',
                `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `topic_id` (`topic_id`)
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8
        ");
    }


    public function down()
    {
        return false;
    }
}