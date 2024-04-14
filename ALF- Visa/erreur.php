<?php
session_start();

if (!isset($_SESSION['error']) and $_SERVER['REDIRECT_STATUS'] == 200) {
    header('Location: /');
    exit();
}

if ($_SERVER['REDIRECT_STATUS'] == 404) $_SESSION['error'] = "Cette page n'existe pas.";
else if ($_SERVER['REDIRECT_STATUS'] == 403) $_SESSION['error'] = "Vous n'avez pas les autorisations nécessaires.";
else if ($_SERVER['REDIRECT_STATUS'] == 500) $_SESSION['error'] = "Erreur Serveur.";
?>
<!DOCTYPE html>

<html lang="fr">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demande de Visa</title>
    <link rel="icon" sizes="192x192" href="/favicon.png">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
	<link href="css/style.css" rel="stylesheet">
  </head>
  
  <body style="background-color: #191918;">
  
	<br>
	
	<center><img src="img/logo.png"></center>
	
		<h1>Demande de Visa</h1>
		<h4>Arma 3 Life France</h4>
		
	<br>
	
		<h4 style="color:red;"><?php echo $_SESSION['error']; ?></h4> 
		
	</br>
		<h4><a>Vous allez être redirigé sur la page de demande de visa.</a></h4> 
	</br>
	</br>
	<?php header("refresh:12;url=index.php");?>
	
		<center><a href="http://visa.arma3lifefrance.fr/" target="_blank">Arma 3 Life France © 2022</a></center>
		
	</div>
  </body>
</html>
<?php
unset($_SESSION['error']);