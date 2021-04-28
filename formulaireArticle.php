<?php 
require_once 'init.php';
// debug($_FILES);

// Post du formulaire des articles
if(!empty($_POST['submit'])&& $_POST['submit'] == 'article'){ 
    $photo_bdd=''; 
    
    //modification de la photo
    if (isset($_POST['photo_actuelle'])){
    $photo_bdd = $_POST['photo_actuelle'];
    }
    
    if (!empty($_FILES['photo']['name'])){
         // redefinit le nom de la photo
        $fichier_photo = 'ref_' . $_POST['titre'] . '_' .$_FILES['photo']['name'];
         //définit le chemin de la photo
        $photo_bdd = 'photo/'. $fichier_photo; 
         //copie de la photo dans notre dossier
        copy($_FILES['photo']['tmp_name'],$photo_bdd); 
        // debug($photo_bdd);
    }

    // Insertion des articles en bdd : 
    $requete=executeRequete("REPLACE INTO article 
                                     VALUES (:id,
                                            :titre,
                                            :contenu,
                                            :photo,
                                            NOW(),
                                            :categorie_id,
                                            :sous_categorie_id)",
                                     array(
                                     ':id'                  =>$_POST['id'],
                                     ':titre'               =>$_POST['titre'],
                                     ':contenu'             =>$_POST['contenu'],
                                     ':photo'               => $photo_bdd,
                                     ':categorie_id'        => $_POST['categorie_id'],
                                     ':sous_categorie_id'   => $_POST['sous_categorie_id']
                                                      
                                     ));

 header('location:index.php');
}

// Insertion des catégories
if(!empty($_POST['submit'])&& $_POST['submit'] == 'categorie'){
    $requete=executeRequete("REPLACE INTO   categorie
                                    VALUES  (:id_categorie,
                                            :nom)",
                                    array(
                                            ':id_categorie' =>$_POST['id_categorie'],
                                            ':nom'          =>$_POST['nom']
                                        ));
}

// Insertiondes sous catégories
if(!empty($_POST['submit'])&& $_POST['submit'] == 'sous_categorie'){
        $requete=executeRequete("REPLACE INTO   sous_categorie
                                        VALUES  (:sous_categorie_id,
                                                :sous_categorie)",
                                        array(
                                                ':sous_categorie_id' =>$_POST['sous_categorie_id'],
                                                ':sous_categorie'  =>$_POST['sous_categorie']
                                            ));
}



// remplissage du formulaire de modification d'un article
if(isset($_GET['id'])){ 
    
    
   $resultat = executeRequete("SELECT * FROM article, categorie, sous_categorie
                            WHERE article.categorie_id=categorie.id_categorie 
                            AND article.sous_categorie_id = sous_categorie.sous_categorie_id 
                         
                            AND id = :id", array('id' => $_GET['id']));
   $article_actuel = $resultat->fetch(PDO::FETCH_ASSOC); 

}



// savoir si l'utilisateur est connecté
if(!estConnecte()){

    header('location:index.php');
    exit();
}
  
require_once 'header.php';          
?>
   
<!-- Formulaire des articles -->
<div class="containerFormulaire">
    <form class="form1" method="post" action="" enctype="multipart/form-data"> 
        <h1>Créer un nouvel article</h1>

        <input type="hidden" name="id" id="id" value="<?php echo $article_actuel['id']?? '';?>">
        <input type="text" placeholder="Titre de l'article"name="titre" id="titre" value="<?php echo $article_actuel['titre']?? '';?>">
        <br> <br>
        <textarea name="contenu" placeholder="Contenu de l'article" id="contenu" cols="30" rows="10"><?php echo $article_actuel['contenu']?? '';?></textarea>
        <br> <br>     

        <div class="labelPhoto espace">
            <label for="categorie_id">Catégorie</label>
            <SELECT name="categorie_id" size="1">
                <?php
                    $categorie = executeRequete("SELECT  * FROM categorie");
                    while($cat = $categorie->fetch(PDO::FETCH_ASSOC)){
                        $selectCat .= '<option';
                        if(isset($article_actuel['id_categorie'])&&$article_actuel['id_categorie'] == $cat['id_categorie']) echo 'selected';
                        $selectCat .=  ' value="'.$cat['id_categorie'].'">'.$cat['nom'] .'</option>'; // on met la première lettre en majuscule avec la fonction prédéfinie ucfirst();  
                    }
                    echo $selectCat;
                ?>
            </SELECT>
        </div>

        <div class="labelPhoto espace">
            <label for="sous_categorie_id">Sous-catégorie</label>
            <SELECT name="sous_categorie_id" size="1">
                <?php
                    $sous_categorie = executeRequete("SELECT  * FROM sous_categorie");
                    while($sous_cat = $sous_categorie->fetch(PDO::FETCH_ASSOC)){
                        $select_sousCat .= '<option value="'.$sous_cat['sous_categorie_id'].'">'.$sous_cat['sous_categorie'].'</option>'; // on met la première lettre en majuscule avec la fonction prédéfinie ucfirst();  
                    }
                    echo $select_sousCat;
                ?>
            </SELECT>
        </div>
        
        <div class="labelPhoto espace">
            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo"><br>  
        </div>

        <!-- Modification de la photo -->
        <?php
            if(isset($article_actuel['photo'])){ // si on est dans modification, on affiche la photo actuelle
                echo '<p> Photo actuelle : </p>';
                echo '<img src="'.$article_actuel['photo'].'" style="width:80px;">';
                echo '<p><input type="hidden" name="photo_actuelle" value="' . $article_actuel['photo']. '"></p>'; 
            }
        ?>

    
        <button class="bouton boutonLiens centrer" name="submit" value="article">Enregistrer l'article</button>
    </form> 
<!---------------------- fin formulaire de la création d'un article----------------------->
    <hr>
    <!-- Début formulaire de création d'une catégorie-->

    <div class="formulaires-cat-sous-cat">
        <form action="" method="post" class="categories-form">
            <h2>Créer une nouvelle catégorie</h2>
            <input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $categorie_actuel['id_categorie']?? '';?>">
            <input type="text" placeholder="Nouvelle categorie" name="nom" id="nom" value="<?php echo $categorie_actuel['nom']?? '';?>">
            <button class="bouton boutonLiens centrer" name="submit" value="categorie">Enregistrer la catégorie</button>
        </form>

        <hr>

     <!-- Début formulaire de création d'une sous_catégorie-->
        <form action="" method="post" class="categories-form">
            <h2>Créer une nouvelle sous-catégorie</h2>
            <input type="hidden" name="sous_categorie_id" id="sous_categorie_id" value="<?php echo $sous_categorie_actuelle['sous_categorie_id']?? '';?>">
            <input type="text" placeholder="Nouvelle sous categorie" name="sous_categorie" id="sous_categorie" value="<?php echo $sous_categorie_actuelle['nom']?? '';?>">
            <button class="bouton boutonLiens centrer" name="submit" value="sous_categorie">Enregistrer la sous catégorie</button></div>
        </form>
    </div>
</div>

<?php require_once 'footer.php';