<?php 


include_once(CLASS_PATH.CLASS_UTILISATEUR_FILE_NAME);


function creerListeUtilisateurs($affichageErreur = false){
    try{
        $listeUtilisateurs = array();

        // Ouvrir le fichier CSV
        $fichier = fopen(CSV_UTILISATEURS_FOLDER_NAME . LISTE_UTILISATEURS_FILE_NAME, "r");

        // Cas d'erreur : le fichier ne peut pas être ouvert
        if($fichier === false){
            throw new Exception("Impossible d'ouvrir le fichier CSV ".LISTE_UTILISATEURS_FILE_NAME);
        }

        // Enlever l'entête du fichier CSV
        fgetcsv($fichier, 0, ";");

        // Lire le fichier CSV
        while(!feof($fichier)){
            $ligne = fgetcsv($fichier, 0, ";");

            // Si la ligne n'est pas vide
            if($ligne != false){
                // Récupérer les informations de l'enseignant
                $id = utf8_encode($ligne[0]);
                $nom = utf8_encode($ligne[4]);
                $prenom = utf8_encode($ligne[5]);
                $role = utf8_encode($ligne[3]);
                $mail = utf8_encode($ligne[1]);
                // Mettre le mail en minuscule
                $mail = strtolower($mail);
                $mdp = utf8_encode($ligne[2]);
                $imgProfil = utf8_encode($ligne[6]);
                // Créer l'objet Utilisateur
                $utilisateur = new Utilisateur($id,$nom, $prenom, $role, $mail, $mdp, $imgProfil);

                // Ajouter l'objet Utilisateur à la liste
                array_push($listeUtilisateurs, $utilisateur);
            }
        }
        return $listeUtilisateurs;
    }
    catch(Exception $e){
        if($affichageErreur){
            throw new Exception($e->getMessage());
        }
        return false;
    }
}

function recupererUtilisateur($id){
    $listeUtilisateurs = creerListeUtilisateurs();
    foreach($listeUtilisateurs as $utilisateur){
        if($utilisateur->getId() == $id){
            return $utilisateur;
        }
    }
    return null;
}

function recupererIdMaxUtilisateurs(){
    $listeUtilisateurs = creerListeUtilisateurs();
    $idMax = 0;
    foreach($listeUtilisateurs as $utilisateur){
        if($utilisateur->getId() > $idMax){
            $idMax = $utilisateur->getId();
        }
    }
    return $idMax;
}

function utilisateurMailExiste($mail){
    $listeUtilisateurs = creerListeUtilisateurs();
    foreach($listeUtilisateurs as $utilisateur){
        if($utilisateur->getMail() == $mail){
            return true;
        }
    }
    return false;
}


?>