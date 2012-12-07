<?php

class ImportEventsFightsFromMongoCommand extends CConsoleCommand
{
    public function run($args)
    {
        $mongo      = new Mongo();
        $collection = $mongo->mma->events_fights;
        $cursor     = $collection->find()->sort(['date_import' => 1]);

        foreach ($cursor as $item)
        {
            p($item);
        }
    }


    private function log($msg, $level = CLogger::LEVEL_INFO)
    {
        Yii::log($msg, $level, 'ImportEventsFightsFromMongoCommand');
    }
}
