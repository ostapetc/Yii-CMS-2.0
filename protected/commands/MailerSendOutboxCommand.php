<?php

class MailerSendOutboxCommand extends CConsoleCommand
{
    public function run($args)
    {
        Yii::app()->getModule('main');
        Yii::app()->getModule('mailer');

        MailerOutbox::sendEmails();
    }


    private function createLockFile()
    {
        $block_file_path = $this->getLockFilePath();
        file_put_contents($block_file_path, "");
        chmod($block_file_path, 0777);
    }


    private function removeLockFile()
    {
        $block_file_path = $this->getLockFilePath();
        if (file_exists($block_file_path))
        {
            unlink($block_file_path);
        }
    }


    private function getLockFilePath()
    {
        $dir = RUNTIME_PATH . 'commands' . DS;
        if (!is_dir($dir))
        {
            mkdir($dir, 0777);
            chmod($dir, 0777);
        }

        return $dir . get_class($this) . '.lock';
    }
}
