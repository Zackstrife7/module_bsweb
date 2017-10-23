<?php
header('Content-Type: application/json');

$_codeErr = 'unknown';
$_err = '';
/**

 * --------------------------------------------------
 * ENVOI POST
 * --------------------------------------------------
**/

if( $_POST['zack_newsletter_email']== '')
{
		
		$_codeErr = 'empty';
		$_err .= ' Veuillez rentrer une adresse email ';
}
elseif ($_POST['zack_newsletter_email']!= '' && preg_match('/^[a-z\d._-]+@[a-z\d._-]{2,}\.[a-z]{2,4}$/', $_POST['zack_newsletter_email'])===0)
{
		$_codeErr = 'wrong';
		$_err .= "Veuillez rentrer une adresse email valide !";
}
else{
		if ($_POST['zack_newsletter_email'] != '' && preg_match('/^[a-z\d._-]+@[a-z\d._-]{2,}\.[a-z]{2,4}$/', $_POST['zack_newsletter_email'])===1) 
		{
			$_codeErr = 'good';
			$_err .= "Vous etes inscrit :)";
		}
}
	
	
	

  $_err  = array('code' => $_codeErr ,'msg' => $_err ); // un tableau avec 2 keys qui comprennent chaque valeurs de code et msg qu'on fera passer

echo json_encode($_err);

?>

