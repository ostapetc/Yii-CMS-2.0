<?
if (MsgStream::getInstance()->count())
{
    echo MsgStream::getInstance()->render();
}
echo $form;