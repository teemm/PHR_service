<ul class="site-map">
	<?php

	function printChildren($item) {
		foreach ($item as $child) {
			$li = '<li>';
			if ($child['redirectable'])
				$li .= '<a href="'.http_url('home/content?menu_id='.$child['id']).'">'.$child['text'].'</a></li>';
			else
				$li .= $child['text'].'</li>';
			
			echo $li;
			if ($child['children']) {
				echo '<ul>';
				printChildren($child['children']);
				echo '</ul>';
			}
		}
	}

	if ($menus)	printChildren($menus);

	?>
</ul>
