<?php
echo $form->getActiveFormWidget()->labelEx($form->model, $element->name);

if ($element->name == 'captcha')
{
    echo $form->getActiveFormWidget()->error($form->model, 'captcha');
    echo CHtml::activeTextField($form->model, 'captcha', array('data-label' => $label));
    $this->widget('Captcha');

}
else if ($element->type == 'date')
{
    $model_class = get_class($form->model);
    echo $form->getActiveFormWidget()->textField($form->model, $element->name, $element->attributes);
    $this->widget('application.extensions.calendar.SCalendar', array(
        'inputField' => "{$model_class}_{$element->name}",
        'ifFormat'   => '%d.%m.%Y',
        'language'   => 'ru-UTF'
    ));
}
else
{
    if ($element->type == 'file')
    {
        ?>
    <input id="file_fake" type="text" readonly="readonly" data-label="<?php echo $label ?>"/>
    <span class="attach" title="Выбрать файл">
        <input type="button" class="file_select_btn" value=""/>
    </span>
    <?php
    }

//    if ($element->type == 'dropdownlist')
//    {
//        $element->items[''] = $label;
//    }

    echo $element->renderInput();

}
echo $form->getActiveFormWidget()->error($form->model, $element->name);

?>