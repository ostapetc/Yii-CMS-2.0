<?
$active_form = $form->getActiveFormWidget();

$no_label = array('meta_tags', 'file_manager');
if (!in_array($element->type, $no_label) && $element->isSafes)
{
    echo $element->renderHint();
    echo $element->renderLabel();
}

echo $element->renderInput();
echo $element->renderError();
