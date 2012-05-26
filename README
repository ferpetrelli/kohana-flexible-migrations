## Kohana Flexible Migrations

Kohana Flexible migrations is a Rails inspired migration module for kohana.
It's based on kohana-migrations module by Matías Montes and Jamie Madill

Some features:

* Solves the problem with migrations numbers using a hash instead of a integer
* Migration generation with one click
* Supports migrations and rollbacks
* Due the naming convention for files, you can work on teams without concerns!
* Nice web interface

## Getting started

1 - Enable flexiblemigrations and orm modules in bootstrap.php

```php
'flexiblemigrations' => MODPATH.'flexiblemigrations'
               'orm' => MODPATH.'orm'
```

2 - Run the migrations.sql script on your DB server

3 - Create and grant write privileges to /application/migrations folder


## Usage

Enter url:  yoursite/migrations and that's it!

Clicking on 'Generate NEW migration' you can create a new migration file.
When you finish editing, simply click on 'Run all pending migrations'.

Enjoy!


## Migration file structure

A typical migration looks like:

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
        'updated_at'          => array('datetime'),
        'created_at'          => array('datetime'),
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