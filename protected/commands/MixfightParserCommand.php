<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 07.10.12
 * Time: 23:42
 * To change this template use File | Settings | File Templates.
 */

class MixfightParserCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        Yii::import('application.modules.mma.components.*');

        $parser = new MixfightParser();
        $parser->parsePosts();
    }
}
