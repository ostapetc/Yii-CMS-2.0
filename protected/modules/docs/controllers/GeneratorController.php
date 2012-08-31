<?php
class GeneratorController extends CController
{

    public static function actionsTitles()
    {

        return array(
            "docsAR" => "Генерация phpDoc для AR",
        );
    }


    public function actionDocsAR()
    {
        $model = new Generator();
        $model->generate();
    }


}