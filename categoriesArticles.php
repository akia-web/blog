<?php
require_once 'init.php';
require_once 'header.php';

$titre="";

if($_GET['nom'] && $_GET['sous_categorie']){
    $navContenu ="";
    $resultat = executeRequete("SELECT titre, photo, contenu, ladate, nom, categorie_id, sous_categorie
                                FROM article, categorie , sous_categorie
                                WHERE article.categorie_id=categorie.id_categorie 
                                AND article.sous_categorie_id = sous_categorie.sous_categorie_id 
                                AND nom = :nom
                                AND sous_categorie = :sous_categorie" , 
                                array(':nom' => $_GET['nom'],
                                        ':sous_categorie' => $_GET['sous_categorie'],                                         
                                )); 
                            
    $titre .= 
            '<div class="containerCategorieArticleTitres">
                <H1 class="titreCategorieArticle">'.ucfirst($_GET['nom'])." - ". ucfirst($_GET['sous_categorie']).' ('.$resultat->rowCOUNT().' articles)</H1>
            </div>';

    while ($article =$resultat->fetch(PDO::FETCH_ASSOC)){   
        $contenu .= '<div class="containerArticle">';

        foreach ($article as $indice=>$valeur){
            if($indice == 'photo'){
                $contenu .= '<img class="articleImage"  src="'.$valeur.'">';
            }elseif($indice == 'contenu'){
                $contenu .= '<p class="contenu">'.$valeur.'</p>';
            }elseif($indice == 'titre'){
                $contenu .= '<h2 class="titre">'.$valeur.'</h2>';
                
            }elseif($indice == 'ladate'){
                ?>
                    <meta charset="utf-8" />
                <?php

                setlocale(LC_TIME, 'fr');

                $date = $valeur;
                $date = strtotime($valeur);
                $date = strftime('%A %d / %m / %Y à %H h %M', $date);
                $contenu .= '<div class="ligneDate"><p class="date">Publié le : '.$date.'</p></div>';

            }
        }    
        $contenu .='</div>';  

    }
    echo $navContenu;            
}


?>


<div class="categorie-colonne">
  
    <nav class="navCategorie">
        <h2 class="titreCategorie">Catégories</h2>
        <?php 
         $categories = getCategories();
         $navContenu .= afficheCategories($categories);
        echo $navContenu; ?>
    </nav>
    
    <div class="truc">
        <?php 
        echo $titre; 
        echo $contenu;
        ?>
    </div>   

</div>
        
<?php
require_once 'footer.php';