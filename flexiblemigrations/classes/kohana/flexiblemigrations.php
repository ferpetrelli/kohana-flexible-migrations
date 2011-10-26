<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Flexible Migrations
 *
 * An open source utility inspired by Ruby on Rails
 *
 * Reworked for Kohana by Fernando Petrelli
 *
 * Based on Migrations module by Jamie Madill
 *
 * @package		Flexiblemigrations
 * @author 		Matías Montes
 * @author    Jamie Madill
 * @author    Fernando Petrelli
 */

class Kohana_Flexiblemigrations
{
	protected $_config;

	/**
	 * Intialize migration library
	 *
	 */
	public function __construct()
	{
		$this->_config = Kohana::config('flexiblemigrations')->as_array();
	}

	// /**
	//  * Installs the schema up to the last version
	//  * Outputs a report of the installation
	//  */
	// public function install()
	// {
	// 	$last_version = $this->last_schema_version();
		
	// 	if ($last_version === FALSE)
	// 	{
	// 		throw new Kohana_Exception(Kohana::lang('migrations.none_found'));
	// 	}
		
	// 	$this->version($last_version);
	// }


	public function get_timestamp() {
		return date('YmdHis');
	}

	public function get_config() {
		return $this->_config;
	}


	public function get_migrations()
	{
		$migrations = glob($this->_config['path'] . '*' . EXT);
		foreach ($migrations as $i => $file)
		{
			$name = basename($file, EXT);
			if (!preg_match('/^\d{14}_(\w+)$/', $name))
				unset($migrations[$i]);
		}
		sort($migrations);
		return $migrations;
	}

	protected function get_migration_keys() {
		$migrations = $this->get_migrations();
		$keys = array();
		foreach ($migrations as $migration) {
			$sub_migration = substr(basename($migration, EXT), 0, 14);
			$keys = Arr::merge($keys, array($sub_migration => substr(basename($migration, EXT), 15)));
		}
		return $keys;
	}

	public function migrate() {
		$migration_keys = $this->get_migration_keys();

		$migrations = ORM::factory('migration')->find_all();

		foreach ($migrations as $migration) {
			if (array_key_exists($migration->hash, $migration_keys)) {
				unset($migration_keys[$migration->hash]);
			}
		}

		if (count($migration_keys) > 0) {
			foreach ($migration_keys as $key => $value) {
				echo "Executing migration: '" . $value . "' with hash: " .$key;

				$migration_object = $this->load_migration($key);
				$migration_object->up();

				$model = ORM::factory('migration');
				$model->hash = $key;
				$model->name = $value;
				$model->save();

				if ($model) {
					echo "  ---  SUCCESS";
				} else {
					echo "  ---  ERROR";
				}
				echo "<br>";
			}
		} else {
			echo "Nothing to migrate";
		}
	}

	public function rollback() {
		//Get last executed migration
		$model = ORM::factory('migration')->order_by('created_at','DESC')->order_by('hash','DESC')->limit(1)->find();

		if ($model->loaded()) {
			$migration_object = $this->load_migration($model->hash);
			$migration_object->down();
			
			if ($model) {
				echo "Migration '" . $model->name . "' with hash: " . $model->hash . ' was succefully removed';
			} else {
				echo "   ---  ERROR WHEN ROLLBACK";
			}
			echo "<br>";
			$model->delete();
		} else {
			echo "Nothing to do.";
		}
	}



	protected function load_migration($version) {

		$f = glob($this->_config['path'] . $version. '*' . EXT);

		if ( count($f) > 1 ) // Only one migration per step is permitted
			throw new Kohana_Exception('migrations.multiple_versions', $version);

		if ( count($f) == 0 ) // Migration step not found
			throw new Kohana_Exception('migrations.not_found', $version);

		$file = basename($f[0]);
		$name = basename($f[0], EXT);

		// Filename validations
		if ( !preg_match('/^\d{14}_(\w+)$/', $name, $match) )
			throw new Kohana_Exception('migrations.invalid_filename', $file);

		$match[1] = strtolower($match[1]);

		include $f[0];
		$class = ucfirst($match[1]);

		if ( !class_exists($class) )
			throw new Kohana_Exception('migrations.class_doesnt_exist', $class);

		if ( !method_exists($class, 'up') OR !method_exists($class, 'down') )
			throw new Kohana_Exception('migrations.wrong_interface', $class);

		return new $class();
	}

}