<?php
require 'class.php';
$user = new User();
$id_whitelist = $_GET['whitelist'];
    $resultlist = $user->query_whitelist($id_whitelist);
?>
<?php
    if($resultlist['isValidate'] == "1"){
        echo("1");
    } else {
        echo("0");
    }
?>
