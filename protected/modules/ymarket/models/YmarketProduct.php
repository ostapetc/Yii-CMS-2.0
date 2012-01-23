<?php

class YmarketProduct extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const IMAGES_DIR = "upload/ymarket/";


    public function name()
    {
        return 'Продукты Яндекс-маркета';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'ymarket_products';
	}


	public function rules()
	{
		return array(
			array('name', 'required'),
			array('brand_id', 'length', 'max' => 11),
			array('name', 'length', 'max' => 150),
			array('image', 'length', 'max' => 38),
            array('desc_html', 'safe'),
			array('id, brand_id, name, image', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'brand' => array(self::BELONGS_TO, 'YmarketBrand', 'brand_id'),
		);
	}


    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['brand'] = 'Бренд';
        return $labels;
    }


    public function imageSrc()
    {
        if (!$this->image)
        {
            return;
        }

        return '/' . self::IMAGES_DIR . $this->image;
    }


    public function getImageHtml($small = false)
    {
        if ($small)
        {
            return ImageHelper::thumb(self::IMAGES_DIR, $this->image, 50, null,  false, $attr_string = "border='0'");
        }
        else
        {
            $src = $this->imageSrc();

            if ($src)
            {
                return "<img src='{$src}' border='0' />";
            }
        }
    }


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('brand_id', $this->brand_id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('image', $this->image, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function parse()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'date_parse';

        $pages = YmarketPage::model()->limit(10)->findAll($criteria);

        if (!$pages)
        {
            Yii::log(
                'Ymarket:: не нашел страниц с продуктами для парсинга',
                'warning',
                'ymarket'
            );
            return;
        }

        foreach ($pages as $page)
        {
            $page->date_parse = new CDbExpression('NOW()');
            $page->save();

            $content = YmarketIP::model()->doRequest($page->url);
            //$content = file_get_contents("/var/www/ParseProducts.html");

            preg_match_all('|<img class="b-offers__img" src="(.*?)"|', $content, $products_images);
            if (!isset($products_images[1]))
            {
                Yii::log(
                    'Ymarket:: не могу спарсить картинки товаров ' . $page->url,
                    'warning',
                    'ymarket'
                );

                return;
            }

            $products_images = $products_images[1];

            preg_match_all('|<div class="b-offers__desc">(.*?)</div>|', $content, $products_desc);
            if (!isset($products_desc[1]))
            {
                Yii::log(
                    'Ymarket:: не могу спарсить описания товаров ' . $page->url,
                    'warning',
                    'ymarket'
                );

                return;
            }

            $products_desc = $products_desc[1];
            foreach ($products_desc as $i => $desc)
            {
                $desc = trim($desc);

                if (empty($desc))
                {
                    unset($products_desc[$i]);
                }
            }

            if (count($products_images) != count($products_desc))
            {
                Yii::log(
                    'Ymarket:: кол-во картинок не совпадает кол-ву описаний ' . $page->url,
                    'warning',
                    'ymarket'
                );

                return;
            }

            $brands = YmarketBrand::model()->findAll(array('order' => 'LENGTH(name) DESC'));
            if (!$brands)
            {
                Yii::log(
                    'Ymarket:: не могу добавить товар так как нет брэндов!',
                    'warning',
                    'ymarket'
                );
            }

            $img_dir = $_SERVER['DOCUMENT_ROOT'] . self::IMAGES_DIR;
            if (!file_exists($img_dir))
            {
                mkdir($img_dir);
                chmod($img_dir, 0777);
            }

            $brands = ArrayHelper::extract($brands, 'id', 'name');

            $products_data = array_combine($products_images, $products_desc);
            foreach ($products_data as $img => $desc_html)
            {
                preg_match('|class="b-offers__name" href=".*?">(.*?)</a>|', $desc_html, $product_name);

                if (!isset($product_name[1]))
                {
                    Yii::log(
                        'Ymarket:: не могу спарсить название продукта ' . $page->url . ' html: ' . $desc_html,
                        'warning',
                        'ymarket'
                    );

                    continue;
                }

                $product_name = $product_name[1];

                foreach ($brands as $id => $brand)
                {
                    if (mb_substr($product_name, 0, mb_strlen($brand)) == $brand)
                    {
                        $brand_id = $id;
                    }
                }

                if (!isset($brand_id))
                {
                    Yii::log(
                        'Ymarket:: не могу определить бренд товара ' . $product_name,
                        'warning',
                        'ymarket'
                    );

                    continue;
                }

                $name = str_replace($brands[$brand_id], null, $product_name);

                $product = YmarketProduct::model()->findByAttributes(array(
                    'brand_id' => $brand_id,
                    'name'     => $name
                ));

                if ($product)
                {
                    $product->date_update = new CDbExpression('NOW()');
                }
                else
                {
                    $product = new YmarketProduct;
                }

                $product->brand_id  = $brand_id;
                $product->name      = $name;
                $product->desc_html = $desc_html;

                if (!$product->save())
                {
                    Yii::log(
                        'Ymarket:: не могу сохранить товар ' . print_r($product->errors, 1),
                        'warning',
                        'ymarket'
                    );

                    continue;
                }

                $img = html_entity_decode($img);
                $img = str_replace('&size=2', '', $img);

                $img_ext  = pathinfo($img, PATHINFO_EXTENSION);
                $img_name = $product->id . '.' . $img_ext;
                $img_path = $img_dir . $img_name;

                try
                {
                    file_put_contents($img_path, file_get_contents($img));
                }
                catch (CException $e)
                {
                    Yii::log(
                        'Ymarket:: ' . $e->getMessage(),
                        'warning',
                        'ymarket'
                    );

                    continue;
                }

                $product->image = $img_name;
                $product->save();
            }
        }
    }
}