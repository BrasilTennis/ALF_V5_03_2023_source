<?php
session_start();

function isValid($name)
{
    $long = strlen($name);
    if ($long == 0 or $long > 24) return FALSE;
    else return TRUE;
}

function clean($name)
{
    $search = array("â", "ë", "à");
    $replace = array("a", "e", "a");

    return str_replace($search, $replace, $name);
}

if (isset($_SESSION['steamid']) and isset($_POST) and isset($_POST['nameplayer'])) //Paramètre steamid existant + inscription envoyée
{
    $steamid = $_SESSION['steamid'];
    $name = clean($_POST['nameplayer']);
    if (!isValid($name)) {
        $_SESSION['error'] = "Votre nom n'est pas valide : veuillez recommencer en suivant les consignes.";
        header("Location: /erreur.php");
        exit();
    }

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
    else //Inscription dans la BDD
    {
        $requete = 'INSERT INTO players (name, playerid, groupeSanguin, position) VALUES (:name, :steamid, "", "[5380.24,7120.52,0.00144005]")';
        $res = $DB->prepare($requete);

        $res->bindParam(':steamid', $steamid, PDO::PARAM_STR);
        $res->bindParam(':name', $name, PDO::PARAM_STR);

        $status = $res->execute();

        if ($status) {
            $_SESSION['name'] = $name;
            $_SESSION['birthdate'] = $_POST['birthdate'];
            $_SESSION['birthplace'] = $_POST['birthplace'];
            $_SESSION['sexe'] = $_POST['sexe'];

            header('Location: /visa.php');
            exit();
        }
        else {
            $_SESSION['error'] = "Erreur lors de l'inscription du visa dans la base de données.";
            header("Location: /erreur.php");
            exit();
        }
    }

}
else {
	if (isset($_SESSION['steamid'])) {
		header('Location: /blabla.php');
		exit();
	} else {
		header('Location: /blfsdfddfsabla.php');
		exit();
	}
}