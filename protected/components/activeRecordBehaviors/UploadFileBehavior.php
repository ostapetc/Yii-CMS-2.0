<?

class UploadFileBehavior extends ActiveRecordBehavior
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

            if (!isset($params["dir"]))
            {
                throw new CException('param "dir" is required in "uploadFiles" method');
            }

            $file_dir = $_SERVER["DOCUMENT_ROOT"] . $params['dir'];

            if (substr($file_dir, -1) !== '/')
            {
                $file_dir.= '/';
            }

            if (!file_exists($file_dir))
            {
                mkdir($file_dir);
                chmod($file_dir, 0777);
            }

            $file_saved = false;

            $upload = CUploadedFile::getInstance($model, $attr);
            if ($upload)
            {
                if ($params['hash_store'])
                {
                    $file_name = $this->generateFileHashName($upload->name);
                }
                else
                {
                    $file_name = $upload->name;
                }

                $file_path  = $file_dir . $file_name;
                $file_saved = $upload->saveAs($file_path);
            }
            else
            {
                $validator = new CUrlValidator();
                if ($validator->validateValue($model->$attr))
                {
                    $image_data = file_get_contents($model->image);
                    $file_name  = $this->generateFileHashName($model->image);
                    $file_path  = $file_dir . $file_name;

                    if (file_put_contents($file_path, $image_data))
                    {
                        $file_saved = true;
                    }
                }

                if (!$model->isNewRecord)
                {
                    $model->$attr = $model->model()->findByPk($model->primaryKey)->$attr;
                }
            }

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
    }


    public function beforeDelete($event)
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


    private function generateFileHashName($file_path)
    {
        $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        return md5(rand(1, 200) . $file_path . time()) . "." . $ext;
    }
}
