<?php
include_once(FONCTION_CRUD_PROMOTIONS_PATH);

echo '
        <h2>
            <form action="'.PAGE_PROMOTIONS_PATH.'" method="post" style="display:inline;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </button>
            </form>
            Supprimer une promotion
        </h2><br>';

if (isset($_POST["nomPromotion"])){
    $nomPromotion = htmlspecialchars(["nomPromotion"]);
    try{
        supprimerPromotion($nomPromotion);
        // Affichage d'un message de succès
        print("
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Succès !</strong>
                        <p>La promotion a bien été supprimée.</p>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
        ");

    }
    catch (Exception $e){
        // Message d'erreur
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo $e->getMessage();
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        echo '</div>';

    }
}
else{
    // Message d'erreur
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo "Erreur : la promotion n'a pas été supprimée.<br>";
    echo "Le nom de la promotion n'a pas été transmis.<br>";
    echo "Si le problème persiste, veuillez contacter l'administrateur du site.<br>";
    echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
    echo '</div>';
}