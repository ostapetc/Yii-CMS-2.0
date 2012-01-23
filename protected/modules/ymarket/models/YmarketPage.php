<?php

class YmarketPage extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Страницы Яндекс-маркета';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_pages';
	}


	public function rules()
	{
		return array(
			array('section_id, url, num', 'required'),
			array('num', 'numerical', 'integerOnly' => true),
			array('section_id', 'length', 'max' => 11),
			array('url', 'length', 'max' => 500),
			array('date_update', 'safe'),

			array('id, section_id, url, num, date_create, date_update', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'section' => array(self::BELONGS_TO, 'YmarketSections', 'section_id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('section_id', $this->section_id, true);
		$criteria->compare('url', $this->url, true);
		$criteria->compare('num', $this->num);
		$criteria->compare('date_create', $this->date_create, true);
		$criteria->compare('date_update', $this->date_update, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function parse()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'date_update IS NOT NULL';
        $criteria->order = 'date_pages_parse';

        $section = YmarketSection::model()->find($criteria);
        $section->date_pages_parse = new CDbExpression('NOW()');
        $section->save();

        if ($section->pages)
        {
            $page = YmarketPage::model()->findByAttributes(
                array('section_id' => $section->id),
                array('order' => 'num DESC')
            );

            $url = $page->url;
        }
        else
        {
            $url = $section->all_models_url;
        }

        $pages_urls = $this->_parse($url);
        if (!$pages_urls)
        {
            return;
        }

        foreach ($pages_urls as $num => $url)
        {
            $page = YmarketPage::model()->findByAttributes(array(
                'section_id' => $section->id,
                'url'        => $url
            ));

            if (!$page)
            {
                $page = new YmarketPage;
                $page->section_id = $section->id;
                $page->url = $url;
                $page->num = $num;

                if (!$page->save())
                {
                    Yii::log(
                        'Ymarket:: почемуто не сохранилась страница в БД ' . $url,
                        'error',
                        'ymarket'
                    );
                }
            }
        }
    }


    private function _parse($url)
    {
        $content = YmarketIP::model()->doRequest($url);

        preg_match('|<div class="b-pager__pages">(.*?)</div>|', $content, $pager_div);
        if (!isset($pager_div[1]))
        {
            Yii::log(
                'Ymarket:: не могу спарсить пэйджер ' . $url,
                'error',
                'ymarket'
            );

            return;
        }

        preg_match_all('|<a class=".*?" href="(.*?)">([0-9]+)</a>|', $pager_div[1], $pages);
        if (!isset($pages[1]))
        {
            Yii::log(
                'Ymarket:: не могу спарсить страницы пэйджера ' . $url,
                'error',
                'ymarket'
            );

            return;
        }

        return array_combine($pages[2], $pages[1]);
    }
}