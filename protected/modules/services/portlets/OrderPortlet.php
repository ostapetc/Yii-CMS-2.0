<?php

class OrderPortlet extends Portlet
{
    public function renderContent()
    {
        $order = new Order();
        $form  = new BaseForm('services.OrderForm', $order);

        $this->render('OrderPortlet', array(
            'form' => $form
        ));
    }
}
