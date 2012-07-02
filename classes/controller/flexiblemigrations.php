<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Flexible Migrations
 *
 * An open source migration module inspired by Ruby on Rails
 *
 * Reworked for Kohana by Fernando Petrelli
 *
 * Based on Migrations module by Jamie Madill
 *
 * @package		Flexiblemigrations
 * @author    Fernando Petrelli
 */


class Controller_FlexibleMigrations extends Kohana_Controller_Template {

  public $template = 'migrations';
  protected $view;

	public function before() 
	{
		// Before anything, checks module installation
		$this->migrations = new Flexiblemigrations(TRUE);
		try 
		{
			$this->model = ORM::factory('migration');
		} 
		catch (Database_Exception $a) 
		{
			echo 'Flexible Migrations is not installed. Please Run the migrations.sql script in your mysql server';
			exit();
		}

		parent::before();
	}

	public function after()
	{
		$message = Session::instance()->get('message',false);
		if ($message) {
			$this->view->set_global('message', $message);
			Session::instance()->delete('message');
		}

		parent::after();
	}

	public function action_index() 
	{
		$migrations=$this->migrations->get_migrations();
		rsort($migrations);

		//Find the migrations already runned from the DB
		$migrations_runned = ORM::factory('migration')->find_all()->as_array('hash');

		$this->view = new View('flexiblemigrations/index');
		$this->view->set_global('migrations', $migrations);
		$this->view->set_global('migrations_runned', $migrations_runned);

		$this->template->view = $this->view;
	}

	public function action_new() 
	{
		$this->view = new View('flexiblemigrations/new');
		$this->template->view = $this->view;
	}

	public function action_create() 
	{
		$migration_name = str_replace(' ','_',$_REQUEST['migration_name']);
		$session = Session::instance();
		
		try 
		{
      if (empty($migration_name)) 
      	throw new Exception("Migration mame must not be empty");

      //Creates the migration file with the timestamp and the name from params
      $file_name = $this->migrations->get_timestamp(). '_' . $migration_name . '.php';
      $config = $this->migrations->get_config();
      $file = fopen($config['path'].$file_name, 'w+');
      
      //Opens the template file and replaces the name
      $view = new View('migration_template');
      $view->set_global('migration_name', $migration_name);
      fwrite($file, $view);
      fclose($file);
      chmod($config['path'].$file_name, 0770);

			//Sets a status message
			$session->set('message', "Migration ".$migration_name." was succefully created. Please Edit.");
		  $this->request->redirect(url::base().Route::get('migrations_route')->uri());
    } 
    catch (Exception $e) 
    { 
			$session->set('message',  $e->getMessage());
    	$this->request->redirect(url::base().Route::get('migrations_new')->uri());
	  }
	}

	public function action_migrate() 
	{
		$this->view = new View('flexiblemigrations/migrate');
		$this->template->view = $this->view;
		try 
		{
			$this->migrations->migrate();
		} 
		catch (Exception $e) 
		{
			echo $e->getMessage();
			exit();
		}
	}

	public function action_rollback() 
	{
		$this->view = new View('flexiblemigrations/rollback');
		$this->template->view = $this->view;
		try 
		{
			$this->migrations->rollback();
		} 
		catch (Exception $e) 
		{
			echo $e->getMessage();
			exit();
		}
	}

}
