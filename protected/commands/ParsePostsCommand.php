<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 29.10.12
 * Time: 23:39
 * To change this template use File | Settings | File Templates.
 */

Yii::import('application.modules.mma.components.*');


class ParsePostsCommand extends CConsoleCommand
{
    public function run($args)
    {
        if (!isset($args[0]))
        {
            die("Error: needs 'parser' parameter\n");
        }

        $parser = new $args[0];
        $parser->parsePosts();
    }
}
