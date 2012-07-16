<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 13.06.12
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */
class TaskAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'manage' => 'Управление операциями и задачами',
            'allow'  => 'Разрешение доступа к операциям'
        );
    }


    public function actionAllow($role_name)
    {
        $role = AuthItem::model()->findByAttributes(array(
            'name' => $role_name,
            'type' => CAuthItem::TYPE_ROLE
        ));

        if (!$role)
        {
            $this->pageNotFound();
        }

        if (isset($_POST['AuthItem']))
        {
            AuthItemChild::model()->deleteAll("parent = '{$role->name}'");

            foreach ($_POST['AuthItem'] as $task_name => $data)
            {
                if (isset($data['description']))
                {
                    $auth_child = new AuthItemChild();
                    $auth_child->parent = $role->name;
                    $auth_child->child  = $task_name;
                    $auth_child->save();

                    continue;
                }
                else
                {
                    foreach ($data['operations'] as $name => $description)
                    {
                        $auth_child = new AuthItemChild();
                        $auth_child->parent = $role->name;
                        $auth_child->child  = $name;
                        $auth_child->save();
                    }
                }
            }

            Yii::app()->user->setFlash('success', t('Сохранено'));
        }

        $tasks = AuthItem::model()->findAll('type = ' . CAuthItem::TYPE_TASK);

        $this->render('allow', array(
            'tasks' => $tasks,
            'role'  => $role->name
        ));
    }


    public function actionManage()
    {
        if (isset($_POST['AuthItem']))
        {
            $items_names = array();
            foreach ($_POST['AuthItem'] as $task_name => $data)
            {
                if (!isset($data['description'])) continue;

                $items_names[] = $task_name;

                if (!isset($data['operations'])) continue;

                foreach ($data['operations'] as $name => $description)
                {
                    $items_names[] = $name;
                }
            }

            $items_names = array_map(function($v) { return "'{$v}'"; },$items_names);
            $items_names = implode(',', $items_names);

            AuthItem::model()->delete("name NOT IN ({$items_names})");

            foreach ($_POST['AuthItem'] as $task_name => $data)
            {
                if (!isset($data['description'])) continue;

                $task = AuthItem::model()->findByPk($task_name);
                if (!$task)
                {
                    $task = new AuthItem();
                    $task->type        = CAuthItem::TYPE_TASK;
                    $task->name        = $task_name;
                    $task->description = $data['description'];
                }

                if ($task->save() && isset($data['operations']))
                {
                    foreach ($data['operations'] as $name => $description)
                    {
                        $operation = AuthItem::model()->findByPk($name);
                        if (!$operation)
                        {
                            $operation = new AuthItem();
                            $operation->type        = CAuthItem::TYPE_OPERATION;
                            $operation->name        = $name;
                            $operation->description = $description;
                        }

                        if ($operation->save())
                        {
                            $auth_item_child = AuthItemChild::model()->findByAttributes(array(
                                'parent' => $task->name,
                                'child'  => $operation->name
                            ));

                            if (!$auth_item_child)
                            {
                                $auth_item_child = new AuthItemChild();
                                $auth_item_child->parent = $task->name;
                                $auth_item_child->child  = $operation->name;
                                $auth_item_child->save();
                            }
                        }
                    }
                }
            }
        }

        $auth_items = array();

        $tasks = $this->getModulesTasks();
        foreach ($tasks as $task)
        {
            $auth_items[] = array(
                'id'          => $task['name'],
                'name'        => $task['name'],
                'exists'      => $task['exists'],
                'description' => $task['description']
            );

            if (isset($task['operations']))
            {
                foreach ($task['operations'] as $operation)
                {
                    $operation['parent'] = $task['name'];
                    $operation['id']     = $operation['name'];

                    $auth_items[] = $operation;
                }
            }
        }

        $data_provider = new CArrayDataProvider($auth_items, array(
            'pagination' => false
        ));

        $this->render('manage', array(
            'data_provider' => $data_provider,
            'tasks' => $this->getModulesTasks(),
        ));
    }


    protected function getModulesTasks()
    {
        $tasks = array();

        $modules = AppManager::getModulesNames();

        foreach ($modules as $module_name => $module_desc)
        {
            $operations     = array();
            $module_actions = AppManager::getModuleActions(ucfirst($module_name) . 'Module');

            foreach ($module_actions as $controller => $actions)
            {
                $prefix = str_replace('Controller', '', $controller);

                foreach ($actions as $name => $description)
                {
                    $name = $prefix . '_' . $name;

                    $exists = AuthItem::model()->exists(" name = '{$name}' AND type = '" . CAuthItem::TYPE_OPERATION . "'");

                    $operations[] = array(
                        'name'        => $name,
                        'description' => $description,
                        'exists'      => $exists
                    );
                }
            }

            $exists = AuthItem::model()->exists(" name = '{$module_name}' AND type = '" . CAuthItem::TYPE_TASK . "'");

            $tasks[] = array(
                'exists'      => $exists,
                'name'        => $module_name,
                'description' => $module_desc,
                'operations'  => $operations
            );
        }

        return $tasks;
    }
}
