<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 28.06.12
 * Time: 22:12
 * To change this template use File | Settings | File Templates.
 */
class MigrationAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'create' => t('Создание миграции')
        );
    }


    public function actionCreate()
    {
        $model = new Migration();
        $form  = new Form('codegen.MigrationForm', $model);

        if ($form->submitted() && $model->validate())
        {
            $res = Yii::app()->db->createCommand("SHOW CREATE TABLE {$model->table}")->queryRow();
            $sql = $res['Create Table'];

            $sql = explode("\n", $sql);
            foreach ($sql as $i => $str)
            {
                if ($i == 0) continue;

                $sql[$i] = str_repeat(' ', 14) . $str;
            }
            $sql = implode("\n", $sql);

            $dir = APP_PATH .  DS . 'modules' . DS . $model->module . DS . 'migrations' . DS;
            if (!is_dir($dir))
            {
                mkdir($dir, 0777);
                chmod($dir, 0777);
            }

            $name = 'm' . date('ymd') . '_' . date('His') . '_' . $model->table . '_create';
            $file = $dir . $name .'.php';

            $params = array(
                'name'  => $name,
                'table' => $model->table,
                'sql'   => $sql
            );

            $code = $this->renderPartial('codegen.views.templates.migration', $params, true);

            file_put_contents($file, $code);
            chmod($file, 0777);

            Yii::app()->user->setFlash('success', t('Создана миграция') . ' ' . $name);
        }

        $this->render('create', array(
            'form' => $form
        ));
    }
}
