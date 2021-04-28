<?php require_once 'init.php';


if(isset($_GET['id'])){ 
    $resultat = executeRequete("SELECT * FROM article WHERE id = :id", array(':id' => $_GET['id'])); 

    if($resultat -> rowCount() == 0){
            header('location:index.php'); 
            exit();
    } 

    $produit = $resultat -> fetch(PDO::FETCH_ASSOC);
    extract($produit); 

}else{ 
    header('location:index.php'); 
    exit();

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">  
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body class="bodyFiche">
    <div class="pageFicheArticle">
        
        <a class="close" href="index.php">x</a>

        <div class="ficheArticleBloc">
            <div class="blocImg">
                <img class="imgFiche" src="<?php echo $photo; ?>" alt="">
            </div>
            <div class="ficheArticleContenu">
                <div class="titre-contenu">
                    <h1 class='titreAfficheArticle titre'><?php echo ucfirst($titre); ?></h1>
                    <p class="contenu"><?php echo ucfirst($contenu); ?></p>
                </div>
                <p class="ficheDate"><?php echo ucfirst($ladate); ?></p>
            </div>
        </div>
    
    
    </div>  
</body>
</html>
 