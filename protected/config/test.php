<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/development.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
            'session' => array(
                'autoStart' => true
            ),
		),
	)
);
