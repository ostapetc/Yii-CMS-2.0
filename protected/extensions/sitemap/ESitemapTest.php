<?php
Yii::import('ext.sitemap.*');

class ESitemapTest extends CDbTestCase
{
	// import the classes you need to verify here
	public $fixtures=array(
		'tasks'=>'Task',
	);
	
	public function testESitemapModelAttributes()
	{
        $e = new ESitemapModel;
		$e->attributes = array('baseModel'=>'Task');
		$this->assertTrue( $e->validate() );
		
		$this->assertEquals('sitemap', $e->scopeName);
	}
	
	/**
	 * Ensure that we're able to look up the models with the specified scope
	 */
	public function testESitemapModelDataLookup()
	{
        $e = new ESitemapModel;
		$e->attributes = array('baseModel'=>'Task');
		$this->assertTrue( $e->validate() );
		
		$data = $e->models;
		$this->assertNotNull($data);
		
		$model = $data[0];
		$this->assertNotNull($model);
		$this->assertTrue( get_class($model) == 'Task');
	}
	
	/*
	 * Set the models to match your proper model types.
	 * Ensure that your test case is able to use Yii::app()->createAbsoluteUrl()
	 * or the test will not work.
	
	public function testESitemapBehavior()
	{
		$sc = array(
			array('baseModel'=>'Task',
				  'route'=>'/task/view',
				  'params'=>array('id'=>'taskId')),			
		);
		
		$eb = new ESitemapBehavior();
		$this->assertNotNull( $eb );
	
		$list = array();
		$eb->populateSitemap($list, $sc);
		
		$this->assertGreaterThan(0, count($list), "List is populated");
		$first = $list[0];
		$this->assertNotNull( $first['loc'], print_r($list, true));

	} */
}