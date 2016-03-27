<link rel="stylesheet" href="<?php echo asset_url('/css/jquery.fancybox-buttons.css'); ?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo asset_url('/js/jquery.fancybox-buttons.js'); ?>"></script>

<script type="text/javascript" src="<?php echo asset_url('/js/jquery.fancybox-thumbs.js'); ?>"></script>

<?php
    $path = FCPATH.'assets/uploads/gallery';

    $imgDir = site_url().'assets/uploads/';

    $scan = scandir($path);
    $images = array();

    foreach ($scan as $child) {
        if ($child == '.' || $child == '..') continue;

        $info = pathinfo($path.'\\'.$child);
        if (isset($info['extension'])) {
            $ext = $info['extension'];
        } else {
            $ext = '';
        }
        
        $name = $info['basename'];

        if ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp' || $ext == 'jpeg') {
            $imgPath = $imgDir.$name;
            array_push($images, $imgPath);
        }
    }
?>

<ul class="gallery">
	<?php 
	if ($images) {
		foreach ($images as $key => $image) { ?>
			<li>
				<a class="fancybox-button" rel="fancybox-button" href="<?php echo $image; ?>" title="">
				<img src="<?php echo $image; ?>" alt="" />
				</a>
			</li>
<?php 	}
	}	?>

</ul>