<?php
echo $form->getActiveFormWidget()->labelEx($form->model, $element->name);
echo $element->renderInput();
echo $form->getActiveFormWidget()->error($form->model, $element->name);
