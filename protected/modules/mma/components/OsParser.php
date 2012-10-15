<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 07.10.12
 * Time: 22:38
 * To change this template use File | Settings | File Templates.
 */

abstract class OsParser extends Component
{
    public abstract function getSource();
    public abstract function getWebUrl();
    public abstract function getAuthorId();


    protected function log($message, $level = 'info')
    {
        Yii::log($message, $level, 'martialArts.' . get_class($this));
    }


    protected function getContent($path)
    {
        $content = @file_get_contents($path);
        if ($content !== false)
        {
            return $content;
        }
        else
        {
            $this->log("Не могу получить ресурс: {$path}", "warning");
        }
    }


    protected function stripTags($html)
    {
        return strip_tags($html, '<iframe><strong><b><p><br><object><param><embed><img>');
    }


    protected function saveModel(ActiveRecord $model)
    {
        if ($model->save())
        {
            $this->log("Сохранена модель #{$model->id}");
        }
        else
        {
            $this->log("Не могу сохранить модель: ", impode("<br/>", $model->errors_flat_array));
        }
    }


    public function prepareHref($href)
    {
        $url = parse_url($href);
        return $url['path'];
    }
}
