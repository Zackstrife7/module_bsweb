<?php


// creation et instanciation du Widget => MODEL Widget
// ==> Pour créer un widget, il vous suffit d'heriter de la classe WP_Widget standard et certaines de ses fonctions.

/*	Cette classe de base contient également des informations sur les fonctions qui doivent être étendues pour obtenir un widget de travail.
	La classe WP_Widget se trouve dans wp-includes / class-wp-widget.php
*/
class Zack_Newsletter_Widget extends WP_Widget

{
		public function __construct()
		{

		  /* un identifiant pour le widget ;
			un titre à afficher dans l’administration ;
            des paramètres supplémentaires comme la description du widget (elle aussi affichée dans le panneau « widget » de l’administration).
         */
            // On utilise le constructeur du parent pour instancié notre Widget 
            parent::__construct('zack_newsletter', 'Newsletter', array('description' => 'Un formulaire d\'inscription à la newsletter.'));
		// on charge le style css
            wp_enqueue_style('general-style-css', plugin_dir_url( __FILE__ ) . '../assets/css/style.css');
		// On charge le script JS
            wp_enqueue_script('general-script-js', plugin_dir_url( __FILE__ ) . '../assets/js/style.js');
        }


	/*Rendu visuel du widget
		 $args=>  un tableau contenant des paramètres d’affichage que nous détaillerons lors de l’implémentation de la méthode. Ils permettent notamment d’obtenir un rendu du widget qui correspond au thème graphique utilisé

		 $instance  => contient les paramètres du widget sauvegardés dans la base de données, c’est-à-dire les paramètres que l’administrateur a définis lors de l’ajout du widget à la zone dédiée
	 */
	 public function widget($args, $instance)
	  {   
	 	include_once plugin_dir_path( __FILE__ ) .'../Views/menu_html_widget.php';

	 }

	/*
	Rendu visuel des parametres du widget stocké dans la bdd  avec l'instance $instance
	*/
	public function form ( $instance ) {
		include_once plugin_dir_path( __FILE__ ) .'../Views/form_widget.php';
	
	}
}
