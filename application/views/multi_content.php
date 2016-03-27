<?php foreach($contents as $content) { ?>

	<div class="dynamic-item">
		<a href="<?php echo http_url('home/content?content_id='.$content['id']) ?>">
			<img src="<?php echo base_url().$content['image']; ?>" class="dynamic-header-img">
		</a>
		<div class="dynamic-info">
			<?php 
				echo '<a href="'.http_url('home/content?content_id='.$content['id']).'" class="news-header"><h4>'.$content['title'].'</h4></a>';
				echo '<p class="item-timestamp">'.date('d/m/Y', strtotime($content['create_time'])).'</p>';
				echo '<div class="dynamic-short-desc">'.$content['short_desc'].'</div>';
				echo '<div class="read-more"><a href="'.http_url('home/content?content_id='.$content['id']).'">'.lang('read_more').'</a></div>';
			?>
		</div>
	</div>

<?php } ?>

<div class="multi-dynamic-pag">
	<ul class="pagination">
		<?php echo $page_links ?>
	</ul>
</div>