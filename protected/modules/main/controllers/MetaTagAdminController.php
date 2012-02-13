<?php

class MetaTagAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'            => 'Просмотр мета-тега',
            'Create'          => 'Создание мета-тега',
            'Update'          => 'Редактирование мета-тега',
            'Delete'          => 'Удаление мета-тега',
            'Manage'          => 'Управление мета-тегами',
            'GetModelObjects' => 'Получение объектов модели',
            'GetMetaTagData'  => 'Получение данных тега'
        );
    }


    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }


    public function actionCreate()
    {
        $model = new MetaTag;

        $this->performAjaxValidation($model);
        $form = new BaseForm('main.MetaTagForm', $model);

        if ($form->submitted('submit'))
        {
            if (isset($_POST['MetaTag']['id']) && is_numeric($_POST['MetaTag']['id']))
            {
                $meta_tag = MetaTag::model()->findByPk($_POST['MetaTag']['id']);
                if ($meta_tag)
                {
                    $model = $meta_tag;
                }
            }

            $model->attributes = $_POST['MetaTag'];
            if ($model->save())
            {
                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
            }
        }

        $this->render('create', array(
            'form' => $form,
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);
        $form = new BaseForm('main.MetaTagForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
            }
        }

        $this->render('update', array(
            'form' => $form,
        ));
    }


    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }


    public function actionManage()
    {
        $model = new MetaTag('search');
        $model->unsetAttributes();
        if (isset($_GET['MetaTag']))
        {
            $model->attributes = $_GET['MetaTag'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }


    public function actionGetModelObjects($model_id)
    {
        $result = array();
        $model  = $model_id::model();

        $criteria            = new CDbCriteria;
        $criteria->condition = " id NOT IN (
            SELECT object_id FROM " . MetaTag::tableName() . "
                   WHERE model_id = '" . $model_id . "'
        )";

        $objects = $model->findAll($criteria);

        foreach ($objects as $i => $object)
        {
            $result[$object->id] = (string)$object;
        }

        echo CJSON::encode($result);
    }


    public function actionGetMetaTagData($model_id, $object_id, $tag)
    {
        echo CJSON::encode(MetaTag::model()->findByAttributes(array(
            'model_id'  => $model_id,
            'object_id' => $object_id,
            'tag'       => $tag
        )));
    }
}
