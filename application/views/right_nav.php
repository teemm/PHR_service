<div class="multimedia noselect">
	<div class="multimedia-header">
		<span><?php echo lang('multimedia'); ?></span>
	</div>
	
	<?php 
		$query = 'SELECT v.token FROM phr_video v '
        .' ORDER BY v.id DESC LIMIT 5';

        $v = $this->db->query($query)->result_array();
		
		foreach ($v as $video) { 
	?>
	<div class="youtube-video">
		<a class="vid fancybox.iframe" href="https://www.youtube.com/embed/<?php echo $video['token']; ?>?rel=0">
			<img src="http://img.youtube.com/vi/<?php echo $video['token']; ?>/mqdefault.jpg">
		</a>
	</div>
	<?php } ?>
</div>
<div class="phr-contact">
	<div class="phr-contact-content">
		<?php
			$geEu = asset_url('/images/banners/eu_banner_geo.png');

	        if (get_language($this) == 'en') {
	            $geEu = asset_url('/images/banners/eu_banner_eng.png');
	        }
		?>

		<a href="<?php echo EU_URL; ?>" class="phr-contact-img" target="_blank">
			<img src="<?php echo $geEu; ?>">
		</a>
		<a href="<?php echo CONTACT_URL; ?>" class="phr-contact-img">
			<img src="<?php echo asset_url('/images/banners/contact_us.jpg'); ?>">
		</a>
		<iframe class="find-us-on-fb" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FPHR.HumanRights&amp;width=168&amp;height=390&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
	</div>
</div>