<?php
session_start();

if (!isset($_SESSION['steamid'])) {
    header('Location: /');
    exit();
}

$steamid = $_SESSION['steamid'];
$ip = "57.128.22.231:3306";
$bdd = "ArmaLife";
$user = "paneladmin";
$passwd = "Ls8Vy8R4Ahm7";
try {
    $DB = new PDO('mysql:host='.$ip.';dbname='.$bdd.';charset=UTF8', $user, $passwd);
} catch (PDOException $e) {
    $_SESSION['error'] = 'Erreur de connection à la base de données : '.$e->getMessage();
    header("Location: /erreur.php");
    exit();
}
$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete = 'SELECT * FROM players WHERE playerid = :steamid';
$res = $DB->prepare($requete) or die(print_r($DB->errorInfo()));
$res->bindParam(':steamid', $steamid, PDO::PARAM_STR);
$status = $res->execute();
if (!$status) {
    $_SESSION['error'] = 'Erreur de connection à la base de données.';
    header("Location: /erreur.php");
    exit();
}
$rows = $res->fetch(PDO::FETCH_OBJ);

if (empty($rows->uid)) //Utilisateur pas inscrit
{
    header("Location: /formulaire.php");
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  </head>
  
  <body style="background-color: #191918;">
  
	<br>
	
	<center><img src="img/logo.png"></center>
	
    <h4>Étape n°1 (Demande de visa) <a style="color: green">effectuée</a></h4><a href="logout" class="button logout"
                                             onclick="return confirm('Voulez-vous vraiment vous déconnecter ?');">Se déconnecter &nbsp; <i class="fa fa-sign-out"></i></a>
    <h5>Votre demande de visa pour Belle-Île-en-Mer :</h5>
    <center>
	
    <table class='table table-striped table-dark' align="center">
        <tr>
            <td><b>Nom</b></td>
        </tr>
        <tr>
            <td><?php echo $rows->name ?></td>
        </tr>
</table><br>
    <div class="input-group" align="center">		  
			<div style="" align="center">
        		<center><a href="https://forum.arma3lifefrance.fr"><button class="button yes">Aller sur le forum &nbsp; <i class="fa fa-arrow-right"></i></button></a></center>
        	</div>
		</div>
	</center>
    </br>
	</br>
	<center><a href="http://www.arma3lifefrance.fr/" target="_blank">Arma 3 Life France © 2022</a></center>
		

  </body>
</html>

