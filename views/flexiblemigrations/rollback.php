<?php foreach ($messages as $message) { ?>
	<?php if (key($message) == 0) { ?> 
		<?php echo $message[0] ?>
	<?php } else { ?> 
		<?php echo $message[key($message)] ?>
		<span class="error">ERROR</span>
	<?php } ?>
<?php } ?>

<?php echo HTML::anchor( Route::get('migrations_route')->uri() , "<br>Back"); ?>
