<?php
class SphinxConfCommand extends CConsoleCommand
{
    public $basePath = 'application.runtime.sphinx';
    public $targetPath = 'application.runtime.sphinx';

    public $indexer = 'E:/tools/sphinx/indexer';
    public $searchd = 'E:/tools/sphinx/searchd';


    public $runSearchd = false;

    public function actionIndex()
    {
        echo $this->getConfig();
    }


    private function getConfig()
    {
        $content = file_get_contents(Yii::getPathOfAlias('main.config') . '/base_sphinx.conf');
        foreach (Yii::app()->getModules() as $id => $module)
        {
            $file = Yii::getPathOfAlias($id) . '/config/sphinx.conf';
            if (is_file($file))
            {
                $content .= file_get_contents($file);
            }
        }

        $content = Yii::app()->text->parseTemplate($content, array(
            'DB_USER'   => Yii::app()->db->username,
            'DB_PASS'   => Yii::app()->db->password,
            'DB_NAME'   => 'cms2',
            //TODO: set data from config
            'DB_HOST'   => 'localhost',
            'BASE_PATH' => 'E:/tools/sphinx',
        ));

        $base = Yii::getPathOfAlias($this->basePath);
        is_dir($base) || mkdir($base, 0777);
        $target = Yii::getPathOfAlias($this->targetPath);
        is_dir($target) || mkdir($target, 0777);

        $file = $target . '/sphinx.conf';
        file_put_contents($file, $content);
        return $file;
    }


    public function getColumns($model)
    {
        $command = Yii::app()->db->commandBuilder->createFindCommand($model->tableName(),
            $model->getDbCriteria());
        Yii::app()->db->createCommand('DROP TABLE IF EXISTS __a')->execute();
        Yii::app()->db->createCommand(
            'CREATE TEMPORARY TABLE IF NOT EXISTS __a (' . $command->getText() . ');')->execute();
        $r = Yii::app()->db->createCommand('SHOW COLUMNS FROM __a;')->queryAll();
        Yii::app()->db->createCommand('DROP TABLE IF EXISTS __a;')->execute();

        $res = array();
        foreach ($r as $field)
        {
            $res[] = $field['Field'];
        }
        return $res;
    }
}