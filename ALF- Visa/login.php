<?php
require 'steamauth/openid.php';
require 'steamauth/config.php';
session_start();

try {
    $openid = new LightOpenID($steamauth['domainname']);

    if (!$openid->mode) {
        $openid->identity = 'https://steamcommunity.com/openid';
        header('Location: '.$openid->authUrl());
    }
    else if ($openid->mode == 'cancel') {
        $_SESSION['error'] = 'Veuillez vous connecter avec Steam pour valider votre demande de visa.';
        header("Location: /erreur.php");
        exit();
    }
    else {
        if ($openid->validate()) {
            $id = $openid->identity;
            $ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
            preg_match($ptn, $id, $matches);

            $_SESSION['steamid'] = $matches[1];
            if (!headers_sent()) {
                header('Location: /formulaire.php');
                exit();
            }
            else { ?>
                <script type="text/javascript">window.location.href = "formulaire";</script>
                <?php
                exit();
            }
        }
        else {
            $_SESSION['error'] = 'Veuillez vous connecter avec Steam pour valider votre demande de visa.';
            header("Location: /erreur.php");
            exit();
        }
    }
}
catch (ErrorException $e) {
    $_SESSION['error'] = 'Erreur de connection à la base de données : '.$e->getMessage();
    header("Location: /erreur.php");
    exit();
}