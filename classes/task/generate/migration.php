<?php defined('SYSPATH') or die('No direct script access.');
 
class Task_Generate_Migration extends Minion_Task
{
    protected $_options = array(
        'name' => NULL,
    );

    public function build_validation(Validation $validation)
    {
        return parent::build_validation($validation)
            ->rule('name', 'not_empty');
    }

    /**
     * Task to build a new migration file
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

        $status = $migrations->generate_migration($params['name']);

        if ($status == 0) 
        { 
            Minion_CLI::write('Migration ' . $params['name'] . ' was succefully created');
            Minion_CLI::write('Please check migrations folder');
        } 
        else 
        {
            Minion_CLI::write('There was an error while creating migration ' . $params['name']);
        }
    }
}