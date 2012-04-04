<?

class UploadFileBehavior extends CActiveRecordBehavior
{
    private $_params = array(
        'hash_store' => true
    );


    public function beforeSave($event)
    {
        $model = $this->getOwner();
        if (!method_exists($model, "uploadFiles"))
        {
            return false;
        }

        $upload_files = $model->uploadFiles();

        foreach ($upload_files as $attr => $params)
        {
            $params = array_merge($this->_params, $params);

            $model->$attr = CUploadedFile::getInstance($model, $attr);

            if ($model->$attr)
            {
                $extension = pathinfo($model->$attr->name, PATHINFO_EXTENSION);

                if ($params['hash_store'])
                {
                    $file_name = md5(rand(1, 200) . $model->$attr->name . time()) . "." . strtolower($extension);
                }
                else
                {
                    $file_name = $model->$attr->name;
                }

                $file_dir = $_SERVER["DOCUMENT_ROOT"] . $params["dir"];
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
                $file_saved = $model->$attr->saveAs($file_path);

                if ($file_saved)
                {
                    chmod($file_path, 0777);

                    if ($file_saved && $model->id)
                    {
                        $object = $model->findByPk($model->id);
                        if ($object->$attr)
                        {
                            FileSystemHelper::deleteFileWithSimilarNames($file_dir, $object->$attr);
                        }
                    }

                    $model->$attr = $file_name;
                }
            }
            else
            {
                if (!$model->isNewRecord)
                {
                    $model->$attr = $model->model()->findByPk($model->primaryKey)->$attr;
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
    		foreach ($files as $attr => $params)
    		{
    			if (!$model->$attr)
    			{
    				continue;
    			}

    			$dir = $params["dir"];

	    		if (substr($dir, 0, strlen($_SERVER['DOCUMENT_ROOT'])) != $_SERVER['DOCUMENT_ROOT'])
				{
					$dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
				}

				if (substr($dir, -1) != '/')
				{
					$dir.= '/';
				}

				FileSystemHelper::deleteFileWithSimilarNames($dir, $model->$attr);
    		}
    	}
    }
}
