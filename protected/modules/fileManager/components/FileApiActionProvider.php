<?php
class FileApiActionProvider extends CWidget
{
    public static function actions()
    {
        return array(
            'existFiles' => 'fileManager.components.ExistFilesAction',
            'savePriority' => 'fileManager.components.SavePriorityAction',
            'upload' => 'fileManager.components.UploadAction',
            'updateAttr' => 'fileManager.components.UpdateAttrAction',
        );
    }
}