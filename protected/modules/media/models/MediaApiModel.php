<?php
abstract class MediaApiModel extends CModel
{
    abstract function findAll(CDbCriteria $criteria);
    abstract function count(CDbCriteria $criteria);
}