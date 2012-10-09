<?php
Yii::import('content.commands.parsers.ContentParserAbstract', true);

class VkVideoGroupParser extends ContentParserAbstract
{

    public function parse()
    {
        Yii::import('application.libs.vk.vkapi', true);
        $conf = Yii::app()->params->vk;
        $vk = new vkapi($conf['app_id'], $conf['key']);
        $res = $vk->api('video.get', array('gid' => 'mma.news'));
        dump($res);
    }

}
