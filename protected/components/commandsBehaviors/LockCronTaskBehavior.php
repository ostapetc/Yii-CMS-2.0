<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 21.01.13
 * Time: 14:48
 * To change this template use File | Settings | File Templates.
 *
 * @property string $lock_file_path
 */

class LockCronTaskBehavior extends CConsoleCommandBehavior
{
    use Getter;

    public $file_handler;


    public function getLockFilePath()
    {
        $dir = Yii::getPathOfAlias('application.runtime.cron') . DIRECTORY_SEPARATOR;
        if (!is_dir($dir))
        {
            mkdir($dir, 0755);
            chmod($dir, 0755);
        }

        $path = $dir . get_class($this->owner) . '.lock';
        if (!is_file($path))
        {
            touch($path);
            chmod($path, 0755);
        }

        return $path;
    }


    public function beforeAction($event)
    {
        parent::beforeAction($event);

        $this->file_handler = fopen($this->lock_file_path, 'r+');

        if (!flock($this->file_handler, LOCK_EX | LOCK_NB))
        {
            throw new CException("Another task working with this command now");
        }
    }


    public function afterAction($event)
    {
        parent::afterAction($event);
        fclose($this->file_handler);
    }
}