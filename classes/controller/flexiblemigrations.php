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


class Controller_Flexiblemigrations extends Kohana_Controller_Template {

  public $template = 'migrations';
  protected $view;

	public function before() 
	{
		// Before anything, checks module installation
		$this->migrations = new Flexiblemigrations(TRUE);
		try 
		{
			$this->model = ORM::factory('Migration');
		} 
		catch (Database_Exception $a) 
		{
			echo 'Flexible Migrations is not installed. Please Run the migrations.sql script in your mysql server';
			exit();
		}

		parent::before();
	}

	public function action_index() 
	{
		$migrations=$this->migrations->get_migrations();
		rsort($migrations);

		//Get migrations already runned from the DB
		$migrations_runned = ORM::factory('Migration')->find_all()->as_array('hash');

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

			$this->migrations->generate_migration($migration_name);

			//Sets a status message
			$session->set('message', "Migration ".$migration_name." was succefully created. Check migrations folder");
	    } 
	    catch (Exception $e) 
	    { 
			$session->set('message',  $e->getMessage());
		}

	 	$this->request->redirect(Route::get('migrations_route')->uri());
	}

	public function action_migrate() 
	{
		$this->view = new View('flexiblemigrations/migrate');
		$this->template->view = $this->view;
	
		$messages = $this->migrations->migrate();
		$this->view->set_global('messages', $messages);
	}

	public function action_rollback() 
	{
		$this->view = new View('flexiblemigrations/rollback');
		$this->template->view = $this->view;

		$messages = $this->migrations->rollback();
		$this->view->set_global('messages', $messages);
	}

}
