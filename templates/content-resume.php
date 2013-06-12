
<?php while (have_posts()) : the_post(); ?>
  <?php the_title( '<h1 class="hentry-title">', ' Resume</h1>') ?>
  <div class="large-4 columns intro">
  	<?php the_post_thumbnail( array(385, 290) ); ?>
  	<div class="intro-content">
	  	<?php the_content(); ?>
	  	<?php
	  		$contact_values = simple_fields_fieldgroup('contact_info');
	  		$phone = $contact_values['phone'];
	  		$clean_phone = preg_replace('/\./', '', $phone);
	  		$email = $contact_values['email'];
	  		echo '<p><span>Phone:</span> <a href="tel:'.$clean_phone.'">' .$phone . '</a></p>';
	  		echo '<p><span>Email:</span> <a href="mailto:'.$email.'">' .$email. '</a></p>';
	  	 ?>
  	</div>
  </div>
  <div class="large-8 columns experience">
	<h2>Experience</h2>
	<hr>
	<?php $experience_values = simple_fields_fieldgroup('work_experience');
		foreach($experience_values as $values) {
			echo '<div class="experience-item">';
		echo '<h3>' .$values['title']. '</h3>';
		echo '<h4>' .$values['name']. ' - <span>' .$values['location']. '</span></h4>';
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
		echo '<p class="accomplishments">' .$values['duties']. '</p></div>';

		 }
	?>
  </div>
  <div class="large-4 columns skills">
	<h2>Skills</h2>
	<hr>
	<?php
		$skills_values = simple_fields_fieldgroup('skills');
		foreach($skills_values as $values) {
			echo '<div class="skill-item"><h3>' .$values['skill']. '</h3>';
			$selection = $values['proficiency'];
				switch($selection) {
					case 'dropdown_num_2':
						echo '<span class="uno"><span>...</span><span>...</span><span>...</span><span>1</span></span>';
					break;

					case 'dropdown_num_3':
						echo '<span class="dos"><span>...</span><span>...</span><span>2</span></span>';
					break;

					case 'dropdown_num_4':
						echo '<span class="tres"><span>...</span><span>3</span></span>';
					break;

					case 'dropdown_num_5':
						echo '<span class="quatro"><span>4</span></span>';
					break;

					case 'dropdown_num_6':
						echo '<span class="cinco"><span>5</span></span>';
					break;
				}
			echo '</div>';
		}
	 ?>
  </div>
  <div class="large-8 columns education">
	<h2>Education</h2>
	<hr>
	<?php
		$education_values = simple_fields_fieldgroup('education');
		foreach ($education_values as $values) {
			echo '<div class="education-item">';
			echo '<h3>' .$values['degree']. '</h3>';
			echo '<p class="grad-info">';
			echo $values['school']. ' - ' .$values['date'];
			echo '</p></div>';
		}
	 ?>
  </div>

<?php endwhile; ?>