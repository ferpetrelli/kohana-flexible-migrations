    
<?php defined('SYSPATH') or die('No direct script access.');
 
class Task_Db_Rollback extends Minion_Task
{
    /**
     * Task to rollback last executed migration
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
            Minion_CLI::write('Flexible Migrations is not installed. Please Run the migrations.sql script in your mysql server');
            exit();
        }

        $messages = $migrations->rollback();

        if (empty($messages)) { 
            Minion_CLI::write("There's no migration to rollback");
        } else {
            foreach ($messages as $message) {
                if (key($message) == 0) { 
                    Minion_CLI::write($message[0]);
                } else { 
                    Minion_CLI::write($message[key($message)]);
                    Minion_CLI::write("ERROR");
                }
            }
        }
    }
}