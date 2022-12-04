<?php


DEFINE("CHEMIN_LISTE_SALLES", CSV_SALLES_PATH.LISTE_SALLES_FILE_NAME);
include(CLASS_PATH.CLASS_SALLE_FILE_NAME);
include(FONCTION_CREER_PLAN_SALLE_PATH);


/**
 * Cette fonction permet de créer une liste de salles
 *
 * @return array
 */

function creerListeSalles()
{
    $monFichier = fopen(CHEMIN_LISTE_SALLES, "r");

    // Récupérer les données du CSV dans un tableau

    if (!($monFichier)) {
        print("Impossible d'ouvrir le fichier \n");
        exit;
    } else {
        $tabCSV = array(array());
        $i = 0;

        // On enleve l'entete
        fgetcsv($monFichier, null, ";");

        // Lecture du reste du CSV
        while ($data = fgetcsv($monFichier, null, ";")) {
             $tabCSV[$i][0] = $data[0];
             $tabCSV[$i][1] = $data[1];
             $i++;
        }

    }

    fclose($monFichier);


    $listeSalles = array();

    // Création des objets de la classe Salle
    for ($j=0; $j<=count($tabCSV)-1; $j++){
        // Création de l'objet Salle
        $uneSalle = new Salle;
        $uneSalle->setNom($tabCSV[$j][0]);
        
        // Création de la relation Plan-Salle si le plan existe
        $uneSalle = creerRelationSallePlan($uneSalle);
        

        $listeSalles[$j] = $uneSalle;
    }

    
    for ($numSalleChercheVoisin=0; $numSalleChercheVoisin<=count($tabCSV)-1; $numSalleChercheVoisin++){
        // Association des voisins des salles
        $nomSalleVoisineAChercher = $tabCSV[$numSalleChercheVoisin][1];

        if ($nomSalleVoisineAChercher!=null){
            // Initialisation d'un incrément
            $numSalleActuelle = 0;

            // Tentative de recherche du voisin si l'objet a été crée
            while($numSalleActuelle < count($listeSalles)){
                $salleActuelle = $listeSalles[$numSalleActuelle];

                if ($salleActuelle->getNom() == $nomSalleVoisineAChercher){
                    $listeSalles[$numSalleChercheVoisin]->lierVoisin($listeSalles[$numSalleActuelle]);
                    break;
                }

                $numSalleActuelle++;
            }
        }
    }


    return $listeSalles;
}


function creerRelationSallePlan($uneSalle){
    // On récupére le nom de la salle
    $nomSalle = $uneSalle->getNom();

    // On tente de créer le plan de la salle
    $planDeLaSalle = creerPlanSalle($nomSalle);

    // On met le plan de la Salle
    $uneSalle->setMonPlan($planDeLaSalle);


    return $uneSalle;
}


?>
