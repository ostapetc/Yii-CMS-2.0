<? echo "<?\n"; ?>
class <?= $name ?> extends EDbMigration
{
    public function up()
    {
        $this->execute("DROP TABLE IF EXISTS `<?= $table ?>`");

        $this->execute("
            <?= $sql . "\n" ?>
        ");
    }


    public function down()
    {
        return false;
    }
}