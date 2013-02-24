## Kohana Flexible Migrations

Kohana Flexible migrations is a Rails inspired migration module for kohana.

It's based on kohana-migrations module by Matías Montes and Jamie Madill.

Some features:

* Kohana 3.0, 3.1, 3.2 and 3.3 compatibility
* Automatic migration file generation
* Minion tasks to generate migrations, execute and rollback them.
* Solves the problem with migrations numbers using a timestamp instead of a integer
* Supports migrations and rollbacks
* Due the naming convention for files, you can work on teams without concerns!
* Nice web interface

## Compatibility

**Kohana 3.3** 'master' branch

**Kohana 3.2** download 'kohana_3.2' branch

**Kohana 3.1** download 'kohana_3.1' branch

**Kohana 3.0** download 'kohana_3.0' branch

NOTE: Minion tasks doesn't work using kohana 3.0

## Installation

1) Download module, and copy the folder to your modules directory. (e.g. modules/flexiblemigrations)

2) Enable flexiblemigrations and orm modules in bootstrap.php

```php
'flexiblemigrations' => MODPATH.'flexiblemigrations'
               'orm' => MODPATH.'orm'
```

3) Run the migrations.sql script on your DB server

4) Create and grant WRITE privileges to /application/migrations folder

## Configuration (optional)

You can set some useful options inside config/config.php file:

- Enable/Disable web frontend (to use only Minion tasks)
```php
'web_frontend' => TRUE
```

- If web frontend is enabled you can change their route
```php
'web_frontend_route' => 'migrations',
```

- Path where migration files are going to be generated
```php
'path' => APPPATH . 'migrations/'
```

## Usage

**COMMAND LINE INTERFACE (Minion tasks):** Go ahead to sub-section "Minion tasks"

**WEB FRONTEND:** Go to url: yoursite/migrations (or your route if you've changed it on config.php file) and that's it! you will see a nice web interface with a menu.

1) Click on 'Generate NEW migration' you can set a name and create a new migration file.

E.g. for a migration called 'typical migration' generated file could be:

```
20120526170715_typical_migration.php
```

2) Edit your file and add the DB functions. (Remember to properly set up() and down() functions)


A typical migration file looks like:

```php
<?
class typical_migration extends Migration
{
  public function up()
  {
    $this->create_table
    (
      'table_name',
      array
      (
        'published'             => array('boolean'),
        'published_at'          => array('datetime'),
        'user_id'               => array('integer'),
        'image_file_name'       => array('string[255]'),
        'full_description'      => array('text'),
      )
    );

    $this->add_column('another_table_name', 'column_name', array('datetime', 'default' => NULL));
  }

  public function down()
  {
    $this->drop_table('table_name');
    $this->remove_column('another_table_name', 'column_name');
  }
}
?>
```

3) When you finish editing, simply click on 'Run all pending migrations'. If you made a mistake, click on 'Rollback'.

*Enjoy!*

## Minion tasks - CLI

NOTE: Works only on kohana 3.1, 3.2, and 3.3 versions.

To generate a new migration:
```
./minion generate:migration --name=MIGRATION_NAME
```

To run all pending migrations
```
./minion db:migrate
```

To rollback last executed migration
```
./minion db:rollback
```

## Migration functions

All possible functions are:

```php
create_table($table_name, $fields, $primary_key = TRUE)
drop_table($table_name)
rename_table($old_name, $new_name)

add_column($table_name, $column_name, $params)
rename_column($table_name, $column_name, $new_column_name)
change_column($table_name, $column_name, $params)
remove_column($table_name, $column_name)

add_index($table_name, $index_name, $columns, $index_type = 'normal')
remove_index($table_name, $index_name)
```

Possible DB columns datatypes are: *

```
text
string[NumberOfCharacters]
decimal
integer
datetime
date
boolean
float
timestamp
time
binary
```

In all cases you can pass a default value (see file example above)

## To do

* Full documentation
* Code refactor
* Improve minion tasks
* Support several DB engines (Postgre, Oracle, etc)

## Contact

*All your contributions are welcome!!! Just make a pull request*

To get some help or give suggestions please contact the author.



