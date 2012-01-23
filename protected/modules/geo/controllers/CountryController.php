<?php
 
class CountryController extends BaseController
{   
    public static function actionsTitles() 
    {
        return array(
            "AutoComplete" => "Автодополнение стран"
        );    
    }


    public function actionAutoComplete()
    {
        if (!isset($_GET["q"])) return;

        $names = array();

        $criteria = new CDbCriteria();
        $criteria->condition = "name LIKE :name";
        $criteria->params = array(":name" => "{$_GET["q"]}%");

        $cities = Country::model()->findAll($criteria);
        foreach ($cities as $city)
        {
            $names[] = $city->name;
        }

        echo implode("\n", $names);
    }
}
