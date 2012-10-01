<?php
class RemoteUploadCommand extends CConsoleCommand
{

    public function run()
    {
        $file = new MediaFile('search', 'local');
        $file->getDbCriteria()->mergeWith(array(
            'condition' => 'target_api IS NOT NULL'
        ));
        $files = $file->findAll();
        foreach ($files as $file)
        {
            $local_api = $file->getApi();
            if ($local_api instanceof LocalApi)
            {
                $file->setApi($file->target_api);
                $file->convertFromLocal($local_api);
                $file->target_api = null;
                $file->save();
            }
        }
    }

}
