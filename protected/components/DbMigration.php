<?php
class DbMigration extends EDbMigration
{
    public function up()
    {
        $transaction = $this->getDbConnection()->beginTransaction();
        try
        {
            $this->beforeSafeUp();
            if ($this->safeUp() === false)
            {
                $transaction->rollBack();
                return false;
            }
            $this->afterSafeUp();
            $transaction->commit();
        } catch (Exception $e)
        {
            echo "Exception: " . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
            echo $e->getTraceAsString() . "\n";
            $transaction->rollBack();
            return false;
        }
    }


    public function beforeSafeUp()
    {
        $this->execute("
            SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
        ");
    }

    public function afterSafeUp()
    {
        $this->execute("
            SET SQL_MODE=@OLD_SQL_MODE;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ");
    }
}