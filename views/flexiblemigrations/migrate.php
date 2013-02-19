<?php if (empty($messages)) { ?> 
	Nothing to migrate
<?php } else { ?>
	<?php foreach ($messages as $message) { ?>
		<?php if (key($message) == 0) { ?> 
			<?php echo $message[0] ?>
			<span class="ok">OK</span>
		<?php } else { ?> 
			<?php echo $message[key($message)] ?>
			<span class="error">ERROR</span>
		<?php } ?>
	<?php } ?>
<?php } ?>

<?php echo HTML::anchor( Route::get('migrations_route')->uri() , "<br>Back"); ?>