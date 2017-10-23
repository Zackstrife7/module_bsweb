<?php
	$title = isset($instance['title']) ? $instance['title'] : '';
?>	
			<!--get_field_id et  get-field_name => methodes generer par WP_Widget genere un ID et name pour chaque champ utilisés par WP  -->
			<label for="<?php echo $this->get_field_name('title'); ?> "> <?php  _e ('Title:') 
			?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?> >" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
	

