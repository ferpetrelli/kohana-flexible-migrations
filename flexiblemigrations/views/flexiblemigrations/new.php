<? $message = Session::instance()->get('message',false); ?>
<? Session::instance()->delete('message'); ?>
<? if ($message) { ?> 
  <div class="message"><?=$message?></div>
<? } ?>

<div>Create New Migration</div>

<form method="post" action="/<?= Route::get('migrations_create')->uri() ?>">
  <?php echo  Form::input('migration_name') ?>
  <?php echo  Form::submit('submit','Create Migration') ?>
</form>

<br>
<div>Please use only alphanumeric characters and spaces</div>