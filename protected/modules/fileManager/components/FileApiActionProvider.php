<?php
class FileApiActionProvider extends CWidget
{

    public static function actionsTitles()
    {
        return array(
            "updateAttr"   => "Редактирование файла",
            "upload"       => "Загрузка файлов",
            "savePriority" => "Сортировка",
            "delete"       => "Удаление файла",
            "existFiles"   => "Загрузка существующих файлов",
        );
    }

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