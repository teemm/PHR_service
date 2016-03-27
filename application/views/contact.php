<div class="info-form">
	<i class="fa fa-print print-icon" id="print"></i>

	<?php
		if (isset($alert)){
			echo $alert;
		}
	?>

	<div class="contact-info">
		<p><?php echo lang('title'); ?></p>
		<p><?php echo lang('address'); ?></p>
		<p><?php echo lang('tel'); ?></p>
		<p><?php echo lang('email').' '; ?><a href="mailto:phr.georgia@gmail.com">phr.georgia@gmail.com</a></p>
	</div>
	<div class="contact-form">
		<form method="POST" action="/home/contact" role="form">
			<div class="form-gr">
				<label for="from"><?php echo lang('email'); ?></label>
				<input type="text" name="from">
			</div>
			<div class="form-gr">
				<label for="subject"><?php echo lang('subject'); ?></label>
				<input type="text" name="subject">
			</div>
			<div class="form-gr">
				<label for="message"><?php echo lang('text'); ?></label>
				<textarea name="message"></textarea> 
			</div>
			<input type="submit" value="<?php echo lang('send'); ?>" class="form-submit">
		</form>
	</div>
</div>
<div class="google-map">
	<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d1489.0379732890583!2d44.77703!3d41.71888!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1424436642358" frameborder="0" style="border:0"></iframe>
</div>