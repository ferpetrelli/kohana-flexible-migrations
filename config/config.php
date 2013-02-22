<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(

	//Enable Web frontend
	'web_frontend' => TRUE,

	//Route path to web frontend
	'web_frontend_route' => 'migrations',

	//Path where migration files are going to be generated
	'path' => APPPATH . 'migrations/'

);
