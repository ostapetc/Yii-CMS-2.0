<?php //check short_open_tag php.ini directive is set
if (ini_get('short_open_tag') != '1')
{
    echo 'Please set short_open_tag directive';
    die;
}
?>