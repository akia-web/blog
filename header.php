<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">  
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <header>
            <nav class="navHead">
                <div class="ligne1">
                    <div class="divTitreBlog">
                        <a href="index.php" class="bouton"><h1 class='titreBlog'>Accueil</h1></a>
                    </div>

                    <div class="lienBlog">
                        <?php
                            if(estConnecte()){
                                ?>
                                    <a href="formulaireArticle.php" class="boutonLiens bouton">Créer un article</a>
                                    <a href="recapArticles.php" class="boutonLiens bouton">Récap</a>
                                <?php 
                            }
                        ?>
                        <a href="https://charline.themecloud.dev/portfoliobdd/" class="bouton bouton-rs"> Portfolio</a>
                    </div>
                </div>          
            </nav>
    </header>