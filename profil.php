<?php

    require_once 'init.php';
    require_once 'header.php';

    if(!estConnecte()){

    header('location:recapArticles.php');
    exit();
    }
?>

<!----------------------------------PARTIE HTML ------------------>
<a href="deconnexion.php">deconnexion</a>