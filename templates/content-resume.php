
<?php while (have_posts()) : the_post(); ?>
  <div class="large-4 columns">
  	<div class="intro"><?php the_content(); ?></div>
  	<div class="skills">
  		<?php
  			$skills_values = simple_fields_fieldgroup('skills');
  			foreach($skills_values as $values) {
  				echo '<h3>' .$values['skill']. '</h3>';
  				echo '<p>';
  				$selection = $values['proficiency'];
  					switch($selection) {
  						case 'dropdown_num_2':
  							echo '1';
  						break;

  						case 'dropdown_num_3':
  							echo '2';
  						break;

  						case 'dropdown_num_4':
  							echo '3';
  						break;

  						case 'dropdown_num_5':
  							echo '4';
  						break;

  						case 'dropdown_num_6':
  							echo '5';
  						break;

  					}
  				echo '</p>';
  			}
  		 ?>
  	</div>
  </div>
  <div class="large-8 columns">
  	<div class="experience">
  		<?php $experience_values = simple_fields_fieldgroup('work_experience');
  			foreach($experience_values as $values) {
				echo '<h2>' .$values['title']. '</h2>';
				echo '<h3>' .$values['name']. '</h3>';
				echo '<h4>' .$values['location']. '</h4>';
				echo '<p>' .$values['duties']. '</p>';
				echo '<p class="date-range">';
				$start = $values['start']['date_format'];
				$end = $values['end']['date_format'];
				$pattern = '([0-9][,]{1,2})';
				echo '<p class="date-range">';
				echo preg_replace($pattern, '', $start). ' - ';
				if ($values['current'])
					echo 'Present';
				else
					echo preg_replace($pattern, '', $end);
				echo '</p>';
	  		 }
	  	?>
  	</div>
  	<div class="education">
  		<?php
  			$education_values = simple_fields_fieldgroup('education');
  			foreach ($education_values as $values) {
  				echo '<h2>' .$values['degree']. '</h2>';
  				echo '<p class="grad-info">';
  				echo $values['school']. ' - ' .$values['date'];
  				echo '</p>';
  			}
  		 ?>
  	</div>
  </div>
<?php endwhile; ?>