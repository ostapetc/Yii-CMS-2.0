<?php
return CMap::mergeArray(
	require(APP_PATH . '/config/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
		),
	)
);