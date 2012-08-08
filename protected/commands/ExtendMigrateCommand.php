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
}
