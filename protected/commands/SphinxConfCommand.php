<?php
class SphinxConfCommand extends CConsoleCommand
{
    public $basePath = 'application.runtime.sphinx';
    public $targetPath = 'application.runtime.sphinx';

    public $indexer = 'indexer';


    public function actionIndex()
    {
        $this->buildDbViews();
        $this->getConfig();
    }

    private function buildDbViews()
    {
        foreach (Yii::app()->getModules() as $id => $module)
        {
            $module = Yii::app()->getModule($id);
            if (!method_exists($module, 'getSearchInfo'))
            {
                continue;
            }
            /** @var $model ActiveRecord */
            foreach ($module->getSearchInfo() as $index => $conf)
            {
                //            $sqls  = $this->prepareCommands($models);
                //            $union = "\n(\n" . implode("\n) UNION (\n", $sqls) . ')';
                $sql   = 'CREATE OR REPLACE VIEW sphinx_view_' . $index . ' AS (' . $conf['sql'] .') ';
                Yii::app()->db->createCommand($sql)->execute();
            }
        }


    }


    private function prepareCommands($models)
    {
        $sqls       = array();
        $all_fields = array();
        $results    = new SplObjectStorage();

        // read columns from query
        /** @var $model ActiveRecord */
        foreach ($models as $config)
        {
            $model = $config['model'];
            $model->getDbCriteria()->select = implode(', ', $config['select']);
            $results[$model] = $config['select'];
            $all_fields      = array_merge($config['select'], $all_fields);
        }

        $sqls = array();
        //add null columns for future union using
        foreach ($models as $config)
        {
            $model = $config['model'];

            $fields = $results[$model];
            //collect new fields with null
            $newFields = array();
            foreach ($all_fields as $alias => $column)
            {
                if (in_array($column, $fields))
                {
                    $newFields[] = $column;
                }
                else
                {
                    $newFields[] = 'null as ' . $alias;
                }
            }

            $model->getDbCriteria()->select = implode(', ', $newFields);
            //get sql by criteria
            $sqls[] = Yii::app()->db->commandBuilder
                ->createFindCommand($model->tableName(), $model->getDbCriteria(), $model->tableName())
                ->getText();
        }

        return $sqls;
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

        $base = Yii::getPathOfAlias($this->basePath);
        is_dir($base) || mkdir($base, 0777);
        $target = Yii::getPathOfAlias($this->targetPath);
        is_dir($target) || mkdir($target, 0777);

        $content = Yii::app()->text->parseTemplate($content, array(
            'BASE_PATH' => '/etc/sphinxsearch',
            'INDEXES_PATH' => '/var/lib/sphinxsearch/data',
        ));

        $file = $target . '/sphinx.conf';
        file_put_contents($file, $content);
        return $file;
    }


    public function getColumns($model)
    {
        $command = Yii::app()->db->commandBuilder->createFindCommand($model->tableName(),
            $model->getDbCriteria());
        Yii::app()->db->createCommand('DROP TABLE IF EXISTS __a')->execute();
        $a = Yii::app()->db->createCommand(
            'CREATE TEMPORARY TABLE IF NOT EXISTS __a (' . $command->getText() . ');');

        $a->execute();
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