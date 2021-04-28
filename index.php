<?php 
    require_once 'init.php';
    require_once 'header.php';

    $navContenu="";
    $affichePhoto="";


    // affichage de la photo
    $resultatphoto = executeRequete("SELECT photo, id FROM article");

    while ($article =$resultatphoto->fetch(PDO::FETCH_ASSOC)){   
    
            foreach ($article as $indice=>$valeur){
                if($indice == 'photo'){
                    $affichePhoto .= 
                    '<a href="ficheArticle.php?id='.$article["id"].'"> 
                        <img class="imagesIndex"  src="http:'.$valeur.'">
                    </a>';
                }
            }    
            
    }

    // affichage de tous les articles 
    $resultat = executeRequete("SELECT titre, photo, contenu, ladate, id FROM article");


    while ($article =$resultat->fetch(PDO::FETCH_ASSOC)){   
        $contenu .= '<div id="'.$article["id"].'" class="containerArticle ">';
            foreach ($article as $indice=>$valeur){
                if($indice == 'photo'){
                    $contenu .= '<img class="articleImage"  src="http:'.$valeur.'">';
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


?>

<!----------------------------------PARTIE HTML ------------------>

<div class="categorie-colonne">
    <nav class="navCategorie">
        <h2 class="titreCategorie">Catégories</h2>
        <?php 
            $categories = getCategories();
            $navContenu .= afficheCategories($categories);
            echo $navContenu;
        ?>
    </nav>


    <div class="truc">
        <?php 
        echo $affichePhoto;
        ?>
    </div>
</div>

<!----------------------------------PARTIE JAVASCRIPT ------------------>

<script type="text/javascript">

    $(".containerArticle").hide();

    // liens
    $("a[href^='#']").click(function (e) {
    

    let idPage = splitHref(this.href);


        let container = document.querySelector("#" + idPage);

        document.querySelector(".active").classList.remove("active");
        container.show()

    
    });




/**
 * Découpe une url pour récupérer la partie après le dièse (ALORS QUE C'EST UN CROISILLON)
 * 
 * Exemple : http://nom_de_domaine.net/toto/#blabla ici blabla sera récupéré.
 * 
 * @param url string Correspond à l'url à découper. 
 * 
 * @return La partie après le croisillon de l'url. Ou une chaine vide s'il n'y pas de croisillon.
 */
function splitHref(url){
   const i = url.indexOf('#');

   if (i == -1){
       console.log("splitfHref : PAS BON, pas de croisillon dans la chaîne");

       return "";
   }

   return url.substr(i+1, url.length - (i + 1));
   //url.substr(i+1);
}
    
    </script>
    <?php
    require_once 'footer.php';