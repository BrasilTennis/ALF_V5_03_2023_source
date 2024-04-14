<?php
if (!empty($_SESSION['steamid'])) {
    require 'config.php';
    $url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid']);
    $content = json_decode($url, TRUE);
    $_SESSION['avatar'] = $content['response']['players'][0]['avatar'];
    $_SESSION['steamid'] = $content['response']['players'][0]['steamid']; //Inutile
    $_SESSION['personaname'] = $content['response']['players'][0]['personaname'];
    $_SESSION['profileurl'] = $content['response']['players'][0]['profileurl'];
    if (isset($content['response']['players'][0]['realname'])) {
        $_SESSION['realname'] = $content['response']['players'][0]['realname'];
    }
    else {
        $_SESSION['realname'] = "Inconnu";
    }
}

else {
    $_SESSION['avatar'] = 'https://arma3lifefrance.fr/forum/data/avatars/l/4/4643.jpg?1523023227';
    $_SESSION['personaname'] = 'TEST';
    $_SESSION['profileurl'] = 'https://arma3lifefrance.fr/forum/';
    $_SESSION['realname'] = 'TEST';
}