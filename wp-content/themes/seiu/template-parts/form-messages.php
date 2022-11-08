<?php foreach (Messages::$messages as $type => $messages): ?>
	<?php if (!empty($messages)): ?>
		<div class="form-messages form-messages--<?php echo $type ?>">
			<?php foreach ($messages as $message): ?>
				<p class="form-messages__message"><?php echo $message ?></p>
			<?php endforeach ?>
		</div>
	<?php endif ?>
<?php endforeach ?>
