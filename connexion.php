<?php
require_once 'init.php';
$message = '';

// Quand l'internaute demande la deconnexion : 
// debug($_GET); 
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){ 
    unset($_SESSION['membre']); // on supprime les infos du membre de la session
    $message = '<div> Vous êtes déconnecté</div>';
}

//Si l'internaute est deja connecté: 
if(estConnecte()){
    header('location:profil.php'); 
    exit();
}

if ($_POST) { // si le formulaire est envoyé
 
    if (empty($_POST['pseudo'])|| empty($_POST['mdp'])){
        $contenu .='<div>Les identifiants sont obligatoires </div>';

    }

    //si pas d'erreur affichée, on peut verifier le pseudo et le mdp en BDD : 
    if(empty ($contenu)){
        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo",
                                    array(':pseudo' => $_POST['pseudo']));

        if ($resultat->rowCount() == 1){ // si il y a une ligne, c'est que le pseudo existe en BDD

            $membre = $resultat->fetch(PDO::FETCH_ASSOC); 
            // debug($membre); 

                 // on verifie le mdp : 
                if($_POST['mdp'] ==  $membre['mdp']) { 

                    $_SESSION['membre'] = $membre; 
                       
                    header('location:recapArticles.php'); 
                    exit(); 

                }else{ 
                    $contenu .='<div> Erreur sur le mdp </div>';
                }   

        }else{ //si le pseudo n'existe pas
            $contenu .= '<div class="alert alert-danger"> Erreur le pseudo </div>';
        }                         
    }
} // fin du if ($_POST)

//------------------------------    AFFICHAGE --------------------------
require_once 'header.php';
?>


<?php
echo $message;
echo $contenu;
?>

<form class="connexion"method="post" action="">
    <h1>Connexion</h1>

    <label for="pseudo">Pseudo</label><br>
    <input type="text" name="pseudo" id="peudo"><br>

    <label for="mdp">Mot de passe</label><br>
    <input type="password" name="mdp" id="mdp"><br>

    <button class="bouton boutonLiens centrer" name="submit" value="categorie">Se connecter</button>


</form>