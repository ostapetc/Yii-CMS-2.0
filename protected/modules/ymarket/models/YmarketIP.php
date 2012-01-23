<?php

class YmarketIP extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'IP адреса Яндекс-маркета';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_ips';
	}


	public function rules()
	{
		return array(
			array('ip', 'required'),
            array('ip', 'unique', 'className' => get_class($this), 'attributeName' => 'ip'),
			array('ip', 'length', 'max' => 40),
			array('ip, last_date_use', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('ip', $this->ip, true);
		$criteria->compare('last_date_use', $this->last_date_use, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function doRequest($url)
    {
        $url_params = parse_url($url);
        if (!isset($url_params["host"]))
        {
            $url= "http://market.yandex.ru" . $url;
        }

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        if ($_SERVER["SERVER_ADDR"] != "127.0.0.1")
        {
            curl_setopt($ch, CURLOPT_INTERFACE, $this->getNext());
        }

		$result = curl_exec($ch);
		curl_close($ch);

    	return $result;
    }


    public function getNext()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'last_date_use';

        $ip = $this->find($criteria);
        if ($ip)
        {
            $ip->last_date_use = new CDbExpression('NOW()');
            $ip->save();
            return $ip->ip;
        }
    }
}