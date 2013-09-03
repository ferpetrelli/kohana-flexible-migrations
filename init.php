<?php defined('SYSPATH') or die('No direct script access.');

$migrations_class   = new Flexiblemigrations(TRUE);
$migrations_config  = $migrations_class->get_config();

// Enabling the Userguide module from my Module
// Kohana::modules(Kohana::modules() + array('userguide' => MODPATH.'userguide'));

//If web frontend is enabled, set the routes
if ($migrations_config['web_frontend'])
{
  Route::set('migrations_route', $migrations_config['web_frontend_route'].'(/<action>)')
  	->defaults(array(
  		'controller' => 'flexiblemigrations',
  		'action'     => 'index',
  	));
}
