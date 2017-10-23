<?php 
// get_admin_page_title => 1 er argument de add_menu_page
		echo '<h1>'.get_admin_page_title().'</h1>';
		?>
		<!-- On appelle le fichier options.php pour enregistrer dans la  table wp_options -->
		<form method="POST" action="options.php">
			<?php  settings_fields('zack_newsletter_settings') ?>
			<!--  fai apparaitre nos setting -->
			<?php do_settings_sections('zack_newsletter_settings') ?>
			
			<?php submit_button(); ?>
		</form>
		<!-- Form qui avec un champ caché, va etre envoyer en POST pour demandder l'envoi des emails -->
		<form method="post" action="">

			<input type="hidden" name="send_newsletter" value="1"/>
			<!-- bouton inclu  dans WP avec son CSS propre -->
			<?php submit_button('Envoyer la Newsletter') ?>
		</form>