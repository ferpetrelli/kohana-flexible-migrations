<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Migrations
 *
 * An open source utility for s/Code Igniter/Kohana inspired by Ruby on Rails
 *
 * Note: This is a work in progress. Merely a wrapper for all the currently
 * existing DBUtil class, and a CI adaptation of all the RoR conterparts.
 * many of the methods in this helper might not function properly in some DB
 * engines and other are not yet finished developing.
 * This helper is being released as a complement for the Migrations utility.
 *
 * Reworked for Kohana by Jamie Madill
 *
 * @package		Migrations
 * @author		Matías Montes
 * @author    Jamie Madill
 */

class Migration
{
	protected $driver;
	protected $db;
	
	// Override these two parameters to set behaviour of your migration
	public $group = 'default';
	public $output = FALSE;
	
	public function __construct($output = FALSE, $group = 'default')
	{
		$this->db = Database::instance($this->group);

		$platform = 'mysql'; // $this->db->platform();
		if ($platform = 'mysqli')
			$platform = 'mysql';
		
		// Set driver name
		$driver = 'Drivers_Mysql';
		
		// Load the driver
		//if ( ! Kohana::auto_load($driver)) {
		//	throw new Kohana_Database_Exception('core.driver_not_found', $platform, get_class($this));
		//}
		
		$this->driver = new $driver($group, $this->db);
		$this->output = $output;
		$this->group  = $group;
	}
	
	protected function log($string)
	{
		if ($this->output)
			echo $string;
	}
	
	public function up()
	{
		throw new Kohana_Exception('migrations.abstract');
	}

	public function down()
	{
		throw new Kohana_Exception('migrations.abstract');
	}
	
	/**
	 * Create Table
	 *
	 * Creates a new table
	 *
	 * $fields:
	 *
	 * 		Associative array containing the name of the field as a key and the
	 * 		value could be either a string indicating the type of the field, or an
	 * 		array containing the field type at the first position and any optional
	 * 		arguments the field might require in the remaining positions.
	 * 		Refer to the TYPES function for valid type arguments.
	 * 		Refer to the FIELD_ARGUMENTS function for valid optional arguments for a
	 * 		field.
	 *
	 * @example
	 *
	 *		create_table (
	 * 			'blog',
	 * 			array (
	 * 				'title' => array ( 'string[50]', default => "The blog's title." ),
	 * 				'date' => 'date',
	 * 				'content' => 'text'
	 * 			),
	 * 		)
	 *
	 * @param	string   Name of the table to be created
	 * @param	array
	 * @param	mixed    Primary key, false if not desired, not specified sets to 'id' column.
	 *                   Will be set to auto_increment, serial, etc.
	 * @return	boolean
	 */
	public function create_table($table_name, $fields, $primary_key = TRUE)
	{
		$this->log("Creating table '$table_name'...");
		$ret = $this->driver->create_table($table_name, $fields, $primary_key);
		$this->log("DONE<br />");
		return $ret;
	}

	/**
	 * Drop a table
	 *
	 * @param string    Name of the table
	 * @return boolean
	 */
	public function drop_table($table_name)
	{
		$this->log("Dropping table '$table_name'...");
		$ret = $this->driver->drop_table($table_name);
		$this->log("DONE<br />");
		return $ret;
	}

	/**
	 * Rename a table
	 *
	 * @param   string    Old table name
	 * @param   string    New name
	 * @return  boolean
	 */
	public function rename_table($old_name, $new_name)
	{
		$this->log("Renaming table '$old_name' to '$new_name'...");
		$ret = $this->driver->rename_table($old_name, $new_name);
		$this->log("DONE<br />");
		return $ret;
	}
	
	/**
	 * Add a column to a table
	 *
	 * @example add_column ( "the_table", "the_field", array('string', 'limit[25]', 'not_null') );
	 * @example add_coumnn ( "the_table", "int_field", "integer" );
	 *
	 * @param   string  Name of the table
	 * @param   string  Name of the column
	 * @param   array   Column arguments array
	 * @return  bool
	 */
	public function add_column($table_name, $column_name, $params)
	{
		$this->log("Adding column '$column_name' to table '$table_name'...");
		$ret = $this->driver->add_column($table_name, $column_name, $params);
		$this->log("DONE<br />");
		return $ret;
	}
	
	/**
	 * Rename a column
	 *
	 * @param   string  Name of the table
	 * @param   string  Name of the column
	 * @param   string  New name
	 * @return  bool
	 */
	public function rename_column($table_name, $column_name, $new_column_name, $params)
	{
		$this->log("Renaming column '$column_name' in table '$table_name' to '$new_column_name'...");
		$ret = $this->driver->rename_column($table_name, $column_name, $new_column_name, $params);
		$this->log("DONE<br />");
		return $ret;
	}
	
	/**
	 * Alter a column
	 *
	 * @param   string  Table name
	 * @param   string  Columnn ame
	 * @param   array   Column arguments
	 * @return  bool
	 */
	public function change_column($table_name, $column_name, $params)
	{
		$this->log("Changing column '$column_name' in table '$table_name'...");
		$ret = $this->driver->change_column($table_name, $column_name, $params);
		$this->log("DONE<br />");
		return $ret;
	}
	
	/**
	 * Remove a column from a table
	 *
	 * @param   string  Name of the table
	 * @param   string  Name of the column
	 * @return  bool
	 */
	public function remove_column($table_name, $column_name)
	{
		$this->log("Removing column '$column_name' in table '$table_name'...");
		$ret = $this->driver->remove_column($table_name, $column_name);
		$this->log("DONE<br />");
		return $ret;
	}

	/**
	 * Add an index
	 *
	 * @param   string  Name of the table
	 * @param   string  Name of the index
	 * @param   string|array  Name(s) of the column(s)
	 * @param   string  Type of the index (unique/normal/primary)
	 * @return  bool
	 */
	public function add_index($table_name, $index_name, $columns, $index_type = 'normal')
	{
		$this->log("Adding index '$index_name' to table '$table_name'...");
		$ret = $this->driver->add_index($table_name, $index_name, $columns, $index_type);
		$this->log("DONE<br />");
		return $ret;
	}

	/**
	 * Remove an index
	 *
	 * @param   string  Name of the table
	 * @param   string  Name of the index
	 * @return  bool
	 */
	public function remove_index($table_name, $index_name)
	{
		$this->log("Removing index '$index_name' from table '$table_name'...");
		$ret = $this->driver->remove_index($table_name, $index_name);
		$this->log("DONE<br />");
		return $ret;
	}

	/**
	 * Execute custom query
	 *
	 * @param   string  SQL query to execute
	 * @return  bool
	 */
	public function sql($query)
	{
		return $this->driver->run_query($query);
	}

	public function commit()
	{
		$this->driver->run_query('COMMIT');
	}	

}
