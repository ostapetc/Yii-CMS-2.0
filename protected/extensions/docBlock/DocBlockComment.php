<?php
/**
 * Know all about CComponent, CModel, CActiveRecord and etc.
 */
class DocBlockComment extends DocBlockLine
{
    public $str;
    public $name = 'comment';


    public function __construct($str)
    {
        $this->str = $str;
        $this->name = md5($str);
    }


    public function afterPopulate()
    {
    }


    /**
     * @return string combined doc string
     */
    public function __toString()
    {
        return "\n" . $this->str . "\n";
    }


    /**
     * Fill himself by $object properties
     *
     * @param $object
     */
    public function populate($object)
    {
    }


    public function getTagLen()
    {
        return 0;
    }


    public function getTypeLen()
    {
        return 0;
    }


    public function getNameLen()
    {
        return 0;
    }

}
