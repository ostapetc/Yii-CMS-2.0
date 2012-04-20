<? $this->pageTitle=Yii::app()->name . ' - Error'; ?>

<h2>Error <? echo $code; ?></h2>

<div class="error">
    <? echo CHtml::encode($message); ?>
</div>