<?php
if (Yii::app()->user->hasFlash('cabinet_form_success'))
{
    Yii::app()->user->getFlash('cabinet_form_success');
}
else
{
    echo  $form;
}

