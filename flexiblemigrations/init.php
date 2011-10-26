<?php defined('SYSPATH') or die('No direct script access.');

// FlexibleMigrations Model (change if neccesary)
// define('FLEXMIGRATION_MODEL', 'migration');

// Enabling the Userguide module from my Module
// Kohana::modules(Kohana::modules() + array('userguide' => MODPATH.'userguide'));


Route::set('migrations_route', 'migrations')
	->defaults(array(
		'controller' => 'flexiblemigrations',
		'action'     => 'index',
	));

Route::set('migrations_new', 'migrations/new')
  ->defaults(array(
    'controller' => 'flexiblemigrations',
    'action'     => 'new',
  ));

Route::set('migrations_create', 'migrations/create')
  ->defaults(array(
    'controller' => 'flexiblemigrations',
    'action'     => 'create',
  ));

Route::set('migrations_migrate', 'migrations/migrate')
  ->defaults(array(
    'controller' => 'flexiblemigrations',
    'action'     => 'migrate',
  ));

Route::set('migrations_rollback', 'migrations/rollback')
  ->defaults(array(
    'controller' => 'flexiblemigrations',
    'action'     => 'rollback',
  ));