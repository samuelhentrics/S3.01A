<?php
/**
 * @file creerListePromotions.php
 * @author Samuel HENTRICS LOISTINE <samuel.hentrics@gmail.com>
 * @brief Fichier contenant les fonctions nécéssaires pour créer
 * la liste des Promotion
 * 
 * @version 1.0
 * @date 2022-11-26
 * 
 * 
 */

include_once(CLASS_PATH . CLASS_PROMOTION_FILE_NAME);
include_once(CLASS_PATH . CLASS_ETUDIANT_FILE_NAME);
include_once(FONCTION_ASSOCIER_ENTETE_LIGNE_PATH);


/**
 * @brief Fonction permettant d'obtenir la liste de toutes les Promotion
 *
 * @return array $listePromotions
 *
 */
function creerListePromotions()
{

    $listePromotions = array();

    // On va traiter chaque fichier dans le dossier /Etudiants/
    $scandir = scandir(CSV_ETUDIANTS_FOLDER_NAME);
    foreach ($scandir as $nomFichier) {
        // S'il s'agit d'un fichier CSV, on suppose qu'il s'agit d'un fichier d'étudiants
        if (preg_match("#\.(csv)$#", strtolower($nomFichier))) {
            // On récupére le nom de la promotion
            $nomPromotion = substr($nomFichier, 0, -4);

            // On récupére une promotion
            $unePromotion = creerUnePromotion($nomPromotion);

            // On ajoute la promotion à la liste des promotions
            $listePromotions[$nomPromotion] = $unePromotion;

        }
    }
    return $listePromotions;

}


/**
 * @brief Fonction permettant de créer une promotion à partir de son nom
 *
 * @param string $nomPromotion Nom de la promotion
 * @return Promotion $unePromotion 
 */
function creerUnePromotion($nomPromotion)
{
    $monFichier = fopen(CSV_ETUDIANTS_FOLDER_NAME . $nomPromotion . ".csv", "r");

    // Créer la liste des controles en lisant le fichier CSV

    if (!($monFichier)) {
        print("Impossible d'ouvrir le fichier \n");
        exit;
    } else {
        // Création d'un objet Promotion
        $maPromotion = new Promotion($nomPromotion);

        // Récupération de l'entête du CSV
        $entete = fgetcsv($monFichier, null, ";");


        if ($entete) {
            // Supprimer les espaces en début et fin de chaque nom de colonne
            if (count($entete) > 0) {
                foreach ($entete as $key => $value) {
                    $entete[$key] = trim($value);
                }
            }


            // Créer un numéro étudiant
            $numeroEtudiant = 0;

            // Lecture du reste du CSV
            while ($uneLigne = fgetcsv($monFichier, null, ";")) {
                // On récupére les informations de l'étudiant
                $unEtudiantInfo = associerEnteteLigne($entete, $uneLigne);

                // On créer l'étudiant
                $unEtudiant = creerEtudiant($unEtudiantInfo, $numeroEtudiant);

                // Ajout de l'étudiant dans la liste des étudiants (clé de la liste = l'email de l'étudiant)
                if($unEtudiant != null){
                    $maPromotion->ajouterEtudiant($unEtudiant);
                }

                // On incrémente le numéro de l'étudiant
                $numeroEtudiant++;
            }
        }
    }

    fclose($monFichier);

    return $maPromotion;
}

/**
 * 
 * @brief Créer un étudiant grâce à une ligne du CSV traité
 * @param array $unEtudiantInfo Ligne du CSV actuelle contenant les informations de l'étudiant actuel
 * @param int $numeroEtudiant Numéro de l'étudiant qui lui sera affecté
 * @return Etudiant Etudiant avec toutes ses informations nom, prenom...
 */
function creerEtudiant($unEtudiantInfo, $numeroEtudiant)
{
    $nomEtudiant = null;
    $prenomEtudiant = null;
    $tdEtudiant = null;
    $tpEtudiant = null;
    $emailEtudiant = null;
    $statuts = null;
    $unEtudiant = null;

    // Création d'un contrôle de la ligne actuelle
    if(isset($unEtudiantInfo[NOM_NOM_COLONNE_ETUDIANT])){
        $nomEtudiant = $unEtudiantInfo[NOM_NOM_COLONNE_ETUDIANT];
    }

    if(isset($unEtudiantInfo[PRENOM_NOM_COLONNE_ETUDIANT])){
        $prenomEtudiant = $unEtudiantInfo[PRENOM_NOM_COLONNE_ETUDIANT];
    }

    if(isset($unEtudiantInfo[TD_NOM_COLONNE_ETUDIANT])){
        $tdEtudiant = $unEtudiantInfo[TD_NOM_COLONNE_ETUDIANT];
    }

    if(isset($unEtudiantInfo[TP_NOM_COLONNE_ETUDIANT])){
        $tpEtudiant = $unEtudiantInfo[TP_NOM_COLONNE_ETUDIANT];
    }

    if(isset($unEtudiantInfo[MAIL_NOM_COLONNE_ETUDIANT])){
        $emailEtudiant = $unEtudiantInfo[MAIL_NOM_COLONNE_ETUDIANT];
    }

    if(isset($unEtudiantInfo[STATUTS_NOM_COLONNE_ETUDIANT])){
        $statuts = $unEtudiantInfo[STATUTS_NOM_COLONNE_ETUDIANT];
    }

    if ($nomEtudiant != null && $prenomEtudiant != null) {

        // Création d'un objet de type Controle avec les informations
        // de la ligne courante que l'on traite dans le CSV
        $unEtudiant = new Etudiant(
            $numeroEtudiant,
            $nomEtudiant,
            $prenomEtudiant,
            $tdEtudiant,
            $tpEtudiant,
            $emailEtudiant
        );


        // Traiter si l'étudiant dispose d'un tiers temps
        $TABLEAUX_MOTS_CLES_TIERS_TEMPS = ["tierstemps", "tiers-temps", "tiers temps"];
        $unEtudiant->setEstTT(contientMot($statuts, $TABLEAUX_MOTS_CLES_TIERS_TEMPS));

        // Traiter si l'étudiant dispose d'un ordinateur
        $TABLEAUX_MOTS_CLES_ORDINATEUR = ["pc", "ordinateur"];
        $unEtudiant->setAOrdi(contientMot($statuts, $TABLEAUX_MOTS_CLES_ORDINATEUR));

        // Traiter si l'étudiant est demissionaire
        $TABLEAUX_MOTS_CLES_DEMISSION = ["demission", "dÃ©mission", "démission", "dÃ©missionnaire", "démissionnaire", "demissionnaire"];
        $unEtudiant->setEstDemissionnaire(contientMot($statuts, $TABLEAUX_MOTS_CLES_DEMISSION));
    }

    return $unEtudiant;
}


/**
 * Récupére un étudiant à partir de son numéro et de la promotion
 * @param int $idEtudiant Numéro de l'étudiant
 * @param string $nomPromotion Nom de la promotion
 * @return Etudiant
 */
function recupererUnEtudiant($idEtudiant, $nomPromotion)
{
    $maPromotion = creerUnePromotion($nomPromotion);
    $listeEtudiants = $maPromotion->getMesEtudiants();

    $unEtudiant = $listeEtudiants[$idEtudiant];

    return $unEtudiant;
}



/**
 * @brief Permet de vérifier si un mot clé est dans une phrase
 * @param string $unePhrase Phrase où l'on doit trouver un mot
 * @param array $tableauMotClee Tableau des mots qui doivent être identifié
 * @return bool
 */
function contientMot($unePhrase, $tableauMotClee)
{
    $bool = false;
    $unePhrase = strtolower($unePhrase);

    # TiersTemps
    if (!empty($unePhrase)){
        $i = 0;
        $max = count($tableauMotClee);
        while (true) {
            // Si on a parcouru tout le tableau, on sort de la boucle
            if ($i == $max) {
                break;
            }

            // On récupére le mot clé
            $key = $tableauMotClee[$i];

            // On vérifie si le mot clé est dans la phrase
            if (preg_match('/\b' . preg_quote($key, '/') . '\b/i', $unePhrase)) {
                $bool = true;
                break;    
            }

            // On incrémente le compteur
            $i++;            
        }
    }
    return $bool;
}

?>