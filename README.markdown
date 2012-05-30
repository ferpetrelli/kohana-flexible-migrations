## Kohana Flexible Migrations

Kohana Flexible migrations is a Rails inspired migration module for kohana.

It's based on kohana-migrations module by Matías Montes and Jamie Madill.

Some features:

* Kohana 3.2 compatibility
* Solves the problem with migrations numbers using a timestamp instead of a integer
* Migration generation with one click
* Supports migrations and rollbacks
* Due the naming convention for files, you can work on teams without concerns!
* Nice web interface

## Installation

1) Download module, and copy the folder to your modules directory. (e.g. modules/flexiblemigrations)

2) Enable flexiblemigrations and orm modules in bootstrap.php

```php
'flexiblemigrations' => MODPATH.'flexiblemigrations'
               'orm' => MODPATH.'orm'
```

3) Run the migrations.sql script on your DB server

4) Create and grant WRITE privileges to /application/migrations folder


## Usage

*Enter url: yoursite/migrations and that's it! you will see a nice web interface with a menu.*

1) Click on 'Generate NEW migration' you can set a name and create a new migration file.

E.g. for a migration called 'typical migration' the generated file could be:

```
20120526170715_typical_migration.php
```

2) Edit your file and add the DB functions


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

3) When you finish editing, simply click on 'Run all pending migrations'. If you made a mistake, click on 'Rollback'

Enjoy!


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

```php
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

In all cases you can pass the default value (see file example above)

## Legacy versions

For Kohana < 3.2 versions please download 'kohana-legacy' branch instead of 'master'.

## To do

* Improve web interface
* Code refactor
* More code comments
* Console support
* Support several DB engines (Postgre, Oracle, etc)
* Bug fixing
* Improve documentation

## Contact

To get some help or give suggestions please contact the author.


