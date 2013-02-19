    
<?php defined('SYSPATH') or die('No direct script access.');
 
class Task_Db_Rollback extends Minion_Task
{
    /**
     * Task to run pending migrations
     *
     * @return null
     */
    protected function _execute(array $params)
    {
        $migrations = new Flexiblemigrations(TRUE);
        try 
        {
            $model = ORM::factory('Migration');
        } 
        catch (Database_Exception $a) 
        {
            echo 'Flexible Migrations is not installed. Please Run the migrations.sql script in your mysql server';
            exit();
        }

        $messages = $migrations->rollback();

        if (empty($messages)) { 
            echo "There's no migration to rollback\n";
        } else {
            foreach ($messages as $message) {
                if (key($message) == 0) { 
                    echo $message[0] . "\n";
                } else { 
                    echo $message[key($message)] . "\n";
                    echo "ERROR\n";
                }
            }
        }
    }
}