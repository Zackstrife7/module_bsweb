<?php
/*
Plugin Name: Zack plugin
Description: Un plugin proposant aux visiteurs de s'inscrire sur le site en fournissant leurs emails afin de recevoir la newsletter
Version: 0.1
Author: Sylvain
Author URI: Zack
License: GPL2
*/

// controller


class Zack_Plugin {

	public function __construct () {

		include_once plugin_dir_path ( __FILE__ ) .'/controller/newsletter.php';
		//  1 si on active le plugin , une table se crée avec id et email 
		register_activation_hook(__FILE__,array('Zack_Newsletter','install'));
		//  2 si on supprime le plugin , la table est alors drop 
		register_uninstall_hook(__FILE__,array('Zack_Newsletter','uninstall'));
		// 3 creation d'un menu pour gérer notre module
		add_action('admin_menu', array($this,'add_admin_menu'));
		new Zack_Newsletter();

		// include_once plugin_dir_path( __FILE__ ).'recent.php';
		// new Zack_Recent();
	}

	public function add_admin_menu(){

			// Creation d'un menu pour notre plugin
			/* param :  titre de la page 
						libéllé du menu 
						intitulés des droits pour l'accés  au menu
						clé ID unique 
						fonction apellé pour le rendu (menu_html)

			*/			
    		add_menu_page('Zack Newsletter', 'Zack Newsletter', 'manage_options', 'zack', array($this, 'menu_html'));
    		// pour ne pas avoir le meme libellé que  le titre principal du menu
    		add_submenu_page('zack', 'Apercu', 'Apercu', 'manage_options', 'zack', array($this, 'menu_html'));
    
	}


	 // la page d'accueil du plugin
	public function menu_html(){
		include_once plugin_dir_path ( __FILE__ ) .'Views/menu_html.php';
	}
	
}

new Zack_Plugin;