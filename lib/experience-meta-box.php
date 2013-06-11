<?php
	echo '<a class="repeatable-add button" href="#">+</a>
			<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
	$i = 0;
	if ($meta) {
		foreach($meta as $row) {
			echo '<li><span class="sort hndle">|||</span>
						<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
						<a class="repeatable-remove button" href="#">-</a></li>';
			$i++;
		}
	} else {
		echo '<li><span class="sort hndle">|||</span>
					<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
					<a class="repeatable-remove button" href="#">-</a></li>';
	}
	echo '</ul>
		<span class="description">'.$field['desc'].'</span>';