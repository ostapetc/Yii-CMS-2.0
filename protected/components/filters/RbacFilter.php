<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 13.07.12
 * Time: 12:04
 * To change this template use File | Settings | File Templates.
 */
class RbacFilter extends CFilter
{
    public function preFilter($filter_chain)
    {
        $item_name = AuthItem::constructName($filter_chain->action->controller->id, $filter_chain->action->id);

        if (Yii::app()->user->checkAccess($item_name))
        {
            $filter_chain->run();
        }
        else
        {
            $msg = null;
            if (YII_DEBUG)
            {
                $msg = t('Зарещено!') . ' ' . t($item_name) . '<br/>';
                $msg.= CHtml::link(
                    'Разрешить для роли "' . Yii::app()->user->role . '"',
                    Yii::app()->createUrl('/rbac/task/allow', array('item_name' => $item_name))
                );
            }

            $filter_chain->action->controller->forbidden($msg);
        }
    }
}
