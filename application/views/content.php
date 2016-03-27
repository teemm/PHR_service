<div class="dyn-content">
	<div class="scrollable">
		
		<?php
			// if (isset($image)) {
			// 	echo '<img class="content-img" src="/'.$image.'">';
			// }

			echo '<div class="item"><i class="fa fa-print print-icon" id="print"></i>';
			echo '<h3 class="content-title">'.$title.'</h3>';

			// $lang = get_language($this);
			// $this->lang->load('calendar', $lang);

			// $time = strtotime($create_time);
			// $day = date('d', $time);
			// $month = date('F', $time);
			// $year = date('Y', $time);
			// $clock = date('h:i', $time);

			// $result_time = $day.' '.lang($month).' '.$year.', '.$clock;

			// echo '<p class="content-time">'.$result_time.'</p>';
			echo '<div class="content-text">'.$desc.'</div>';
			echo '</div>';
		?>
	</div>
</div>