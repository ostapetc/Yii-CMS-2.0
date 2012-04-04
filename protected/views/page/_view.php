<div class="view">

	<b><? echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<? echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('language')); ?>:</b>
	<? echo CHtml::encode($data->language); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<? echo CHtml::encode($data->title); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<? echo CHtml::encode($data->url); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<? echo CHtml::encode($data->text); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('is_published')); ?>:</b>
	<? echo CHtml::encode($data->is_published); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('date_create')); ?>:</b>
	<? echo CHtml::encode($data->date_create); ?>
	<br />

	<? /*
	<b><? echo CHtml::encode($data->getAttributeLabel('order')); ?>:</b>
	<? echo CHtml::encode($data->order); ?>
	<br />

	*/ ?>

</div>