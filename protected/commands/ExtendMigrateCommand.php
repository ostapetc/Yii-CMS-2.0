<?php
Yii::import('ext.migrate.EMigrateCommand');
class ExtendMigrateCommand extends EMigrateCommand
{
    protected function getTemplate()
    {
        if ($this->templateFile!==null) {
            return parent::getTemplate();
        } else {
            return str_replace('EDbMigration', 'DbMigration', parent::getTemplate());
        }
    }

    public function actionUp($args)
    {
        $this->getDbConnection()->createCommand("
            SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
        ")->execute();
        parent::migrateUp($args);
        $this->getDbConnection()->createCommand("
            SET SQL_MODE=@OLD_SQL_MODE;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ")->execute();
    }
}
