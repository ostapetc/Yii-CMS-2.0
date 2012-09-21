<?php
abstract class MediaApiModel extends CModel
{
    abstract function findAll($criteria);
    abstract function findByPk($pk);
    abstract function count($criteria);
}