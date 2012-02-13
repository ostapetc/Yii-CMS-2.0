<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artos
 * Date: 13.09.11
 * Time: 18:09
 * To change this template use File | Settings | File Templates.
 */
 
class DbLogRoute extends CDbLogRoute
{
	protected function processLogs($logs)
	{
		$sql="INSERT INTO {$this->logTableName} (level, category, message)
                     VALUES (:level, :category, :message) ";

		$command=$this->getDbConnection()->createCommand($sql);
		foreach($logs as $log)
		{
			$command->bindValue(':level',$log[1]);
			$command->bindValue(':category',$log[2]);
			$command->bindValue(':message',$log[0]);
			$command->execute();
		}
	}
}
