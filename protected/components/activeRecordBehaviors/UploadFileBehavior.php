<?php

class UploadFileBehavior extends CActiveRecordBehavior
{
    public function beforeSave($event)
    {
        $model = $this->getOwner();

        if (method_exists($model, "uploadFiles"))
        {
            $upload_files = $model->uploadFiles();

            foreach ($upload_files as $param => $data)
            {
                $model->$param = CUploadedFile::getInstance($model, $param);
                if ($model->$param)
                {
                    $extension = pathinfo($model->$param->name, PATHINFO_EXTENSION);
                    $file_name = md5(rand(1, 200) . $model->$param->name . time()) . "." . strtolower($extension);

                    $file_dir = $_SERVER["DOCUMENT_ROOT"] . $data["dir"];
                    if (substr($file_dir, -1) !== '/')
                    {
                    	$file_dir.= '/';
                    }

                    if (!file_exists($file_dir))
                    {
                        mkdir($file_dir);
                        chmod($file_dir, 0777);
                    }

                    $file_path  = $file_dir . $file_name;
                    $file_saved = $model->$param->saveAs($file_path);

                    if ($file_saved)
                    {
                        chmod($file_path, 0777);

                        if ($file_saved && $model->id)
                        {
                            $object = $model->findByPk($model->id);
                            if ($object->$param)
                            {
                                FileSystem::deleteFileWithSimilarNames($file_dir, $object->$param);
                            }
                        }

                        $model->$param = $file_name;
                    }
                }
                else
                {
                	if (!$model->isNewRecord)
                	{	
                		$model->$param = $model->model()->findByPk($model->primaryKey)->$param;
                	}
                }
            }
        }
    }


    public function beforeDelete()
    {
        $model = $this->getOwner();

    	if (method_exists($model, "uploadFiles"))
    	{
    		$files = $model->uploadFiles();
    		foreach ($files as $param => $data)
    		{
    			if (!$model->$param)
    			{
    				continue;
    			}

    			$dir = $data["dir"];

	    		if (substr($dir, 0, strlen($_SERVER['DOCUMENT_ROOT'])) != $_SERVER['DOCUMENT_ROOT'])
				{
					$dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
				}

				if (substr($dir, -1) != '/')
				{
					$dir.= '/';
				}

				FileSystem::deleteFileWithSimilarNames($dir, $model->$param);
    		}
    	}
    }
}
