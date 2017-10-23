<?php
//on inclut le modele de notre widget pour le manipuler 
include_once plugin_dir_path(__FILE__).'../models/newsletterwidget.php';
// CONTROLLER du plugin

class Zack_Newsletter{

	public function __construct () {
		// à l'initialisation des widgets, on declare le widget crée
		add_action('widgets_init', function(){register_widget('Zack_Newsletter_Widget');});
		// quand l'aplli est chargée , on apelle la function save_email
		add_action('wp_loaded',array($this,'save_email'),20);
		add_action('wp_loaded',array($this,'auto_answer_to_admin'),10);
		// quand le menu est chargé , apelle de la fucntion add admin menu
		add_action('admin_menu',array($this,'add_admin_menu'),20);
		// quand admin est init , on enregistre le champ zack_newsletter_sender
		add_action('admin_init',array($this,'register_settings'));

	}
	// effectue les actions nécéssaires lors de l'activation du plugin .
	public static function install(){
		global $wpdb;

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}zack_newsletter_email(id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) NOT NULL);");

	}
	public static function uninstall(){
		global $wpdb;

		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}zack_newsletter_email;");
	}

	public function save_email(){
		if (isset($_POST['zack_newsletter_email']) && ($_POST['zack_newsletter_email'])!='' && isset($_POST['sub_email'])) 
		{
			
			global $wpdb;
			// on stocke l'adresse email entré par le  client dans une variable
			$email = $_POST['zack_newsletter_email'];
			if (preg_match('/^[a-z\d._-]+@[a-z\d._-]{2,}\.[a-z]{2,4}$/', $email)===1) 
			{
				// $row va verifié si l'adresse entré n'existe pas déja ;
				$row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}zack_newsletter_email WHERE email = '$email'");
				// si la requete ne retourne aucun resultat ...
				if (is_null($row)) 
				{
					// insert insere une  nouvelle adresse grace à l'API WP
					// param  nom de la table ou on veut inserer la ligne
					//   	  tableau associatif contenant les valeur de la ligne pour chaque champ de la table	
					$wpdb->insert("{$wpdb->prefix}zack_newsletter_email",array('email'=>$email)); 
					
					$to = $email;
					$sender = 'zackstrife34000@gmail.com';
					$subject = 'Abonnement NewsLetter :';
					$message = 'Merci de vous etre abonné à notre NewsLetter ';
					$header = array('From: '.$sender);

					wp_mail($to, $subject, $message, $header);


					

				}
			}
			


		}
	}

	public function add_admin_menu(){
		$hook = add_submenu_page('zack','Newsletter','Newsletter','manage_options','zack_newsletter',array($this,'menu_html_plugin'));
		// Dans cette méthode process_action(), nous vérifions la présence du paramètre send_newsletter avant d’appeler la méthode d’envoi.
		add_action('load-'.$hook,array($this,'process_action'));
	}
	public function auto_answer_to_admin(){
		global $wpdb;

		if (isset($_POST['zack_newsletter_email']) && !empty($_POST['zack_newsletter_email']) && isset($_POST['sub_email'])) 
		{
			$email = $_POST['zack_newsletter_email'];
			$row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}zack_newsletter_email WHERE email = '$email'");

			if(is_email($email) && is_null($row)){

				$recept = 'zackstrife34000@gmail.com';
				$sujet = 'Un Nouvel enregistrement à la newsletter -PriceComparator:';
				$content = 'Nouvel abonné '.$email;

				return wp_mail( $recept, $sujet,$content,$headers= '');
			}
		}
		

	}
	// le sous menu  du plugin newsletter
	public function menu_html_plugin(){
		include_once plugin_dir_path(__FILE__).'../Views/menu_html_plugin.php';
	}


	public function register_settings(){
		// en envoyant le form , on place une nouvelle option_name=> zack_newsletter_sender
		 /*param    id pour grouper les options
					le nom de l'option à créer
		*/
					register_setting('zack_newsletter_settings','zack_newsletter_sender');
					register_setting('zack_newsletter_settings','zack_newsletter_object');
					register_setting('zack_newsletter_settings','zack_newsletter_content');
					register_setting('zack_newsletter_settings', 'zack_newsletter_file');
					// ajoute une nouvelle section  dans les parametres 
					add_settings_section('zack_newsletter_section', 'Paramètres d\'envoi', array($this, 'section_html'), 'zack_newsletter_settings');
		//  se charge de l'ajout de champ à une section donnéex
					add_settings_field('zack_newsletter_sender','Expéditeur',array($this,'sender_html'),'zack_newsletter_settings','zack_newsletter_section');
					add_settings_field('zack_newsletter_object','Objet',array($this,'object_html'),'zack_newsletter_settings','zack_newsletter_section');
					add_settings_field('zack_newsletter_content','Contenu',array($this,'content_html'),'zack_newsletter_settings','zack_newsletter_section');
					add_settings_field( 'zack_newsletter_file','Fichier à joindre ', array($this,'file_html'),'zack_newsletter_settings','zack_newsletter_section');
				}

	// Les fonctions html renvoie les views en allant chercher les fonctions natives de wp et de son artchitecture prédéfinie 
				public function section_html(){
					include_once plugin_dir_path(__FILE__).'../Views/section_html.php';
				}

				public function sender_html(){
					include_once plugin_dir_path( __FILE__ ).'../Views/sender_html.php';

				}
				public function object_html(){
					include_once plugin_dir_path( __FILE__ ).'../Views/object_html.php';
				}
				public function content_html(){

					include_once plugin_dir_path( __FILE__ ).'../Views/content_html.php';

				}
				public function file_html(){
					include_once plugin_dir_path( __FILE__ ).'../Views/file_html.php';

				}

				public function process_action(){
// Dans cette méthode process_action(), nous vérifions la présence du paramètre send_newsletter avant d’appeler la méthode d’envoi.
					if (isset($_POST['send_newsletter'])) {
						$this->send_newsletter();
					}
				}

	// send_newsletter() 
	/*
		pour envoyer les emails à nos visiteurs inscrits. Nous allons donc devoir récupérer les paramètres de configuration choisis ainsi que la liste des emails, puis appeler la fonction wp_mail() qui permet de construire un email.
	*/
		public function send_newsletter(){
			global $wpdb;
		// contient tout les emails  (fetchall ) de la table zack_newsletter_email
			$recipients = $wpdb->get_results("SELECT email FROM {$wpdb->prefix}zack_newsletter_email");

			// $file_folder = WP_PLUGIN_DIR .'upload/pdf';
			$object = get_option('zack_newsletter_object','Newsletter');
			$content = get_option('zack_newsletter_content','Mon Contenu');
			$sender = get_option('zack_newsletter_sender','zackstrife34000@gmail.com');
			$header = array('From: '.$sender);
			$attachments = get_option('zack_newsletter_file','Fichier à joindre');

			foreach ($recipients as $recipient){
 			// $result = mail($recipient->email, $object,$content, 'From: '.$sender);
				$result = wp_mail($recipient->email,$object,$content, $header,$attachments =array(WP_CONTENT_DIR . ''));


			}

		}

	}


	
