<?php 
    require_once 'init.php';

    $reponseSuppression = "";
    $contenuCategorie = "";
    $contenuSousCategorie ="";

    //SUPPRIMER UN ARTICLE
    if(isset($_GET['id'])){
        $succes=executeRequete("DELETE FROM article WHERE id=:id", array(':id' => $_GET['id']));

        if($succes -> rowCount()==1){ 

            $reponseSuppression .= '<div class="success">Vous  avez supprimé l\'article ! </div>';
        } else {
            $reponseSuppression .= '<div class="unSuccess">Vous n\'avez pas supprimé l\'article! </div>';
        }
    }

    // SUPPRIMER UNE CATEGORIE
    if(isset($_GET['id_categorie'])){
        $succes=executeRequete("DELETE FROM categorie WHERE id_categorie=:id_categorie", array(':id_categorie' => $_GET['id_categorie']));
        
        if($succes -> rowCount()==1){ 
    
            $reponseSuppression .= '<div class="success">Vous  avez supprimé la categorie ! </div>';
        } else {
            $reponseSuppression .= '<div class="unSuccess">Vous n\'avez pas supprimé la categorie! </div>';
        }
        }
        
    // SUPPRIMER UNE SOUS CATEGORIE
    if(isset($_GET['sous_categorie_id'])){
        $succes=executeRequete("DELETE FROM sous_categorie WHERE sous_categorie_id=:sous_categorie_id", array(':sous_categorie_id' => $_GET['sous_categorie_id']));
        
        if($succes -> rowCount()==1){ 
    
            $reponseSuppression .= '<div class="success">Vous  avez supprimé la sous-categorie ! </div>';
        } else {
            $reponseSuppression .= '<div class="unSuccess">Vous n\'avez pas supprimé la sous-categorie! </div>';
        }
    }

    // affichage des articles :

    $resultat = executeRequete("SELECT * FROM article, categorie,sous_categorie
    WHERE article.categorie_id=categorie.id_categorie
    AND article.sous_categorie_id = sous_categorie.sous_categorie_id ;"); 

    $contenu .='<p class="nbArticle"> Nombre d\'articles : ' .$resultat->rowCOUNT() . '</p>';

    while ($article =$resultat->fetch(PDO::FETCH_ASSOC)){   
        $contenu .= '<div class="recap">';
        

        foreach ($article as $indice=>$valeur){
        
            if($indice == 'titre'){
                $contenu .= '<p class="recapTitre recapText"> Titre : ' . $valeur . '</p>';
            }elseif($indice == 'contenu'){
                $contenu .= '<p class="recapContenu recapText"> Contenu : '.substr($valeur, 0 , 100). '...</p>';
            }elseif($indice == 'photo'){
                $contenu .= '<p class=" recapText"> Image : <p class="recapImage"><img style="width:90px;"  src="'.$valeur.'"></p></p>';          
            }elseif($indice == 'nom'){
                $contenu .='<p class="recapCategorie recapText"> Catégorie : ' . $valeur. '</p>';
            }elseif($indice == 'sous_categorie'){
                $contenu .='<p class="recapCategorie recapText"> Sous-catégorie : ' . $valeur. '</p>';
            }
        }

        // ajout des liens modifier et supprimer : 
        $contenu .= '<div class="modif-suppr"><a href="formulaireArticle.php?id='. $article['id'].'" class="recapA">  <img class="rs" src="../images/edit-button.svg" > </a> 
                    <a href="?id='.$article['id'].'" class="recapA"> <img class="rs" src="../images/delete.svg" > </a> </div>';
        $contenu .='</div>';       
    }

    // affichage des categories
    $resultatCategorie = executeRequete("SELECT * FROM categorie"); 

    while ($categorie =$resultatCategorie->fetch(PDO::FETCH_ASSOC)){   
        $contenuCategorie .= '<div class="recapCategories">';

            foreach ($categorie as $indice=>$valeur){
                if($indice == 'nom'){
                    $contenuCategorie .= '<p>'.$valeur.'</p>';    
                }
            }
        
        // ajout des liens modifier et supprimer : 
        $contenuCategorie .= '<a href="?id_categorie='.$categorie['id_categorie'].'"> <img class="poubelle" src="../images/delete.svg" > </a> ';
        $contenuCategorie .='</div>';       
    }

    // affichage des sous Categories
    $resultatSousCategorie = executeRequete("SELECT * FROM sous_categorie"); 

    while ($Souscategorie =$resultatSousCategorie->fetch(PDO::FETCH_ASSOC)){   
        $contenuSousCategorie .= '<div class="recapCategories">';
        
            foreach ($Souscategorie as $indice=>$valeur){
                if($indice == 'sous_categorie'){
                    $contenuSousCategorie .= '<p>'.$valeur.'</p>';    
                }
            }
    
        // ajout des liens modifier et supprimer : 
        $contenuSousCategorie .= '<a href="?sous_categorie_id='.$Souscategorie['sous_categorie_id'].'"> <img class="poubelle" src="../images/delete.svg" > </a>';
        $contenuSousCategorie .='</div>';       
    }


    require_once 'header.php';
    if(!estConnecte()){
        header('location:articles.php');
        exit();
    }
?>

<!----------------------------------PARTIE HTML ------------------>
<button class="bouton boutonLiens sedeconnecter"><a href="deconnexion.php">se deconnecter</a></button>

<?php echo $reponseSuppression; ?>

<div class="containerPageRecap">
    <div class="recapArticle">
        <h2>Tous les articles</h2>
        <?php echo $contenu; ?>
    </div>

    <div class="recapCat-sousCat">
        <div class="categorie">
            <h2 class="titreRecap">Catégories</h2>
            <?php echo $contenuCategorie; ?>
        </div>
        
        <div class="categorie">
            <h2 class="titreRecap">Sous Catégories</h2>
            <?php echo $contenuSousCategorie;?>
        </div>
    </div>
  
</div>