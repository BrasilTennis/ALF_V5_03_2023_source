<?php
$data = json_decode(file_get_contents('https://api.steampowered.com/IGameServersService/GetServerList/v1/?filter=\appid\107410\addr\213.246.45.224:2303&key=164EFA7E91C45F371FF25B7B5E04DF4B'));
$main = $data->response->servers[0];
$name = $main->name;
$address = $main->addr;
$version = $main->version;
$players = $main->players;
$max_players = $main->max_players; 
$map = $main->map;
$bots = $main->bots;
echo "$players/$max_players";