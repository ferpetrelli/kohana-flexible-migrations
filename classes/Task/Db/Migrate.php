    
<?php defined('SYSPATH') or die('No direct script access.');
 
class Task_Db_Migrate extends Minion_Task
{
    protected $_defaults = array(
        'foo' => 'bar',
        'bar' => NULL,
    );
 
    /**
     * This is a demo task
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

        $migrations->migrate();
        
        echo 'se deberia haber ejecutado';
    }
}