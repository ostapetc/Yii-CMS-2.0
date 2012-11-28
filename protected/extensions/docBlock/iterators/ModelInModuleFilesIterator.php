<?php
/**
 * Iterator by moduleId.models.* directories for all modules(Yii::app()->getModules())
 * recursive
 */
class ModelInModuleFilesIterator extends AppendIterator
{
    public function __construct()
    {
        parent::__construct();
        foreach (Yii::app()->getModules() as $id => $data)
        {
            $modelsDir = Yii::app()->getModule($id)->getBasePath() . '/models';
            if (!is_dir($modelsDir))
            {
                continue;
            }

            $flags = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS;
            $this->append(new RecursiveDirectoryIterator($modelsDir, $flags));
        }
    }
}