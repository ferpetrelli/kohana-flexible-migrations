<?php defined('SYSPATH') or die('No direct script access.');

$migrations_class   = new Flexiblemigrations(TRUE);
$migrations_config  = $migrations_class->get_config();

// Enabling the Userguide module from my Module
// Kohana::modules(Kohana::modules() + array('userguide' => MODPATH.'userguide'));

//If web frontend is enabled, set the routes
if ($migrations_config['web_frontend'])
{
  Route::set('migrations_route',$migrations_config['web_frontend_route'])
  	->defaults(array(
  		'controller' => 'flexiblemigrations',
  		'action'     => 'index',
  	));

  Route::set('migrations_new',$migrations_config['web_frontend_route'] . '/new')
    ->defaults(array(
      'controller' => 'flexiblemigrations',
      'action'     => 'new',
    ));

  Route::set('migrations_create',$migrations_config['web_frontend_route'] . '/create')
    ->defaults(array(
      'controller' => 'flexiblemigrations',
      'action'     => 'create',
    ));

  Route::set('migrations_migrate',$migrations_config['web_frontend_route'] . '/migrate')
    ->defaults(array(
      'controller' => 'flexiblemigrations',
      'action'     => 'migrate',
    ));

  Route::set('migrations_rollback',$migrations_config['web_frontend_route'] . '/rollback')
    ->defaults(array(
      'controller' => 'flexiblemigrations',
      'action'     => 'rollback',
    ));
}
