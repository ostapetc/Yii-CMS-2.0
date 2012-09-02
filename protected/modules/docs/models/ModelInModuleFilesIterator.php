<?php
class ModelInModuleFilesIterator extends AppendIterator
{
    public function __construct()
    {
        parent::__construct();
        foreach (Yii::app()->getModules() as $id => $data)
        {
            $modelsDir = Yii::app()->getModule($id)->getBasePath() . '/models';
            if (!is_dir($modelsDir) || $id == 'docs')
            {
                continue;
            }
            $this->append(new RecursiveDirectoryIterator($modelsDir, FilesystemIterator::SKIP_DOTS));
        }
    }
}