<?php $message = Session::instance()->get_once('message',false); ?>
<?php if ($message) { ?>
  <div class="message"><?php echo $message?></div>
<?php } ?>

<div>Create New Migration</div>

<?php echo Form::open(Route::get('migrations_create')->uri()); ?>
  <?php echo  Form::input('migration_name') ?>
  <?php echo  Form::submit('submit','Create Migration') ?>
<?php echo Form::close(); ?>

<br>
<div>Please use only alphanumeric characters and spaces, and don't use php reserved words</div>
