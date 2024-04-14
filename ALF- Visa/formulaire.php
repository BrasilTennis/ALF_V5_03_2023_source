<?php
session_start();

if (!isset($_SESSION['steamid'])) {
    header("Location: /");
    exit();
}
include('steamauth/userInfo.php');

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

if (!empty($rows->uid)) //Utilisateur déjà inscrit
{
    $_SESSION['error'] = 'Votre visa est déjà existant.';
    header("Location: /visa.php");
    exit();
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
	
		<h1>Demande de Visa</h1>
    <h4>Information de votre profil Steam :</h4><a href="logout" class="button logout"
                                             onclick="return confirm('Voulez-vous vraiment vous déconnecter ?');">Se déconnecter &nbsp; <i class="fa fa-sign-out"></i></a>
        <h4>Vous avez enregistré votre compte (uniquement l'ID a été sauvegardé). Désormais, vous pouvez commencer à entrer vos
            informations personelles.</h4>

    <center>
	
    <table class='table table-striped table-dark' align="center">
        <tr>
            <td><b>Avatar</b></td>
            <td><b>Nom</b></td>
            <td><b>Pseudo</b></td>
        </tr>
        <tr>
            <td><img src='<?=$_SESSION['avatar']?>'></td>
            <td><?=$_SESSION['realname']?></td>
            <td><a href="<?= $_SESSION['profileurl'] ?>" target="_blank"><?=$_SESSION['personaname']?></a></td>
        </tr>
    </table>
    
	<div style="group">
    <form method="post" action="inscription.php" autocomplete="off">
        	<div style="group" align="center">
        	    <h4><strong>Nom de votre personnage :</h4></strong>
					  <input type="text" name="nameplayer" class="form__input" placeholder="John Doe" maxlength="24" required>
                      
		  
			<h5>(Identique au nom de profil Arma 3)</h5>
        	<h5 style="color:red;"><strong>Attention</strong>, si le nom n'est pas conforme aux règles, la demande de Visa sera refusée !!</h5><br>
        	      

        <table class='table table-striped table-dark'>
            <tr>
                <td colspan="2" class="text-center">Naissance</td>
                <td>Sexe</td>
            </tr>
            <tr>
                <td><input type="date" class="form__input" name="birthdate" title="Votre date de naissance" placeholder="John Doe"
                           required></td>
                <td><input type="text" class="form__input" name="birthplace" title="Votre lieu de naissance" placeholder="Lieu"
                           required></td>
                <td><select title="Votre sexe" name="sexe" required class="form__input">
                        <option>Femme</option>
                        <option>Homme</option>
                    </select></td>
            </tr>
        </table>


		<div class="input-group" align="center">		  
			<div style="" align="center">
        		<center><button type="submit" class="button yes">Envoyer ma demande &nbsp; <i class="fa fa-check"></i></button></center>
        	</div>
		</div>

    </form>
	</div>	
	
	</center>
    </br>
		</br>
		<center><a href="http://www.arma3lifefrance.fr/" target="_blank">Arma 3 Life France © 2022</a></center>
		
	</div>
  </body>
</html>