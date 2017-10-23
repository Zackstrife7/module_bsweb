<?php

		echo $args['before_widget'];
		echo $args['before_title'];
		// pour que les clients puissent modifier l'affichage des widgets
		echo apply_filters('widget_title', $instance['title']);
		echo $args['after_title'];
		?>
		<form id="zack_css" action="" method="post" novalidate="novalidate" >
		
		        <label id="titre" for="zack_newsletter_email">Votre email :</label>
		        <p><input  id="zack_newsletter_email" name="zack_newsletter_email" type="email"/></p>
		        <p><input id="sending" type="submit" value="S'inscrire à la newsletter" name="sub_email" /></p>
		        <p> <span id="reponse"></span></p>

		</form>

		<?php
		echo $args['after_widget'];
		?>
