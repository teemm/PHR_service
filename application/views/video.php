<?php 
	$query = 'SELECT v.token FROM phr_video v '
        .' ORDER BY v.id '
        .' DESC ';

        $v = $this->db->query($query)->result_array();

        $videos = array();

        foreach ($v as $value) {
            array_push($videos, $value['token']);
        }

        // echo "<pre>";
        // var_dump($videos);
        // echo "</pre>";
        // die();

	// $videos = array();

	// array_push($videos, '2eYlEboM8kQ');
	// array_push($videos, 'sLi8L7ppWfM');
	// array_push($videos, 'ZEWqebSchzA');
	// array_push($videos, '9BGsSOfLCaw');
	// array_push($videos, 'Hqzmsp-eanw');
	// array_push($videos, 'x-knk-SfTH8');
	// array_push($videos, 'bN6Njl3lGyE');
	// array_push($videos, 'Vf-p22EUqWk');
	// array_push($videos, 'KVrjHlw6X_E');
	// array_push($videos, 'jCdUd6Rog6E');
	// array_push($videos, '66p_RL8RIU0');
	// array_push($videos, 'QoaBEEOU_aY');
	// array_push($videos, 'nsvA44K4lvg');
	// array_push($videos, 'RBHo4knyB1Q');
	// array_push($videos, 'Dt2yaEg4QZI');
	// array_push($videos, 'kCx4bdDwIDc');
	// array_push($videos, '7ektzfH4VMo');
	// array_push($videos, 'J43XFDZlQnE');
	// array_push($videos, 'kpAGkXKYsiI');
	// array_push($videos, 'OG5i1Y6mv_k');
	// array_push($videos, 'QYyow_LJFpM');
	// array_push($videos, 'K6u2D6vj6tY');
	// array_push($videos, 'g3se_XVA4Po');
	// array_push($videos, 'L7R4D7lB6hw');
	// array_push($videos, 'jKf0GmYUoA8');
	// array_push($videos, '856Bl8xWBTw');
	// array_push($videos, 'cwe5qzqApGU');
	// array_push($videos, 'tJbN17BGCpc');
	// array_push($videos, 'lwQAD0-NDkY');
	// array_push($videos, 'cLgCl5XmJdU');
	// array_push($videos, 'Df5uBH_t7YY');
	// array_push($videos, 'gpxc1GgveWQ');
	// array_push($videos, '5vXMoFRHf2Q');
	// array_push($videos, 'l54637Cy1yo');
	// array_push($videos, 'NArb0aMiYSg');
	// array_push($videos, 'd2WV6ERwDkw');

	$PerPage = 15;
	$nVideos = count($videos);

	$page = $this->input->get('page');

	if ($page) {
	    $page = $page - 1;
	    if (!$page || !is_numeric($page) || $page < 0 || is_float($page + 0))
	        $page = 0;
	} else {
		$page = 0;
	}

	$first = $page * $PerPage;
	$last = ($page + 1) * $PerPage;

	if ($last > $nVideos) {
		$last = $nVideos;
	}

	for ($i = $first; $i < $last; $i++) {
		$video_url = $videos[$i];
		$iframe = 'https://www.youtube.com/embed/'.$video_url.'?rel=0';
		$image = 'http://img.youtube.com/vi/'.$video_url.'/mqdefault.jpg';
?>

	<div class="multimedia-iframe">
		<a class="vid fancybox.iframe" href="<?php echo $iframe; ?>">
			<img src="<?php echo $image; ?>">
		</a>
	</div>

<?php }
	$allPages = ceil($nVideos/$PerPage);
	$page++;

	if ($page <= $allPages) {
		$root_url = base_url().'home/content?menu_id='.$this->input->get('menu_id').'&page=';

		$links = '';

		$doublePrev = $page - 2;
		$prev = $page - 1;
		$next = $page + 1;
		$doubleNext = $page + 2;

		if ($page > 1) $links .= '<li><a href="'.$root_url.$prev.'"><</a></li>';

		if ($doublePrev > 0) $links .= '<li><a href="'.$root_url.$doublePrev.'">'.$doublePrev.'</a></li>';
		if ($prev > 0) $links .= '<li><a href="'.$root_url.$prev.'">'.$prev.'</a></li>';

		$links .= '<li><span class="current-page">'.$page.'</span></li>';

		if ($next <= $allPages) $links .= '<li><a href="'.$root_url.$next.'">'.$next.'</a></li>';
		if ($doubleNext <= $allPages) $links .= '<li><a href="'.$root_url.$doubleNext.'">'.$doubleNext.'</a></li>';

		if ($page < $allPages) $links .= '<li><a href="'.$root_url.$next.'">></a></li>';
?>

<div class="multi-dynamic-pag">
	<ul class="pagination">
		<?php echo $links; ?>
	</ul>
</div>

<?php } ?>