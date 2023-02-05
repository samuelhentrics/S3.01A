<div class="container">
  <div class="col-3"></div>
  <div class="col-6 m-auto">
    <h2>Modifier un enseignant</h2>

    <?php
    include_once(FONCTION_CREER_LISTE_ENSEIGNANTS_PATH);

    if (isset($_POST["idEnseignant"])) {
        $idEnseignant = $_POST["idEnseignant"];

        if(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["statut"])){
            include_once(FONCTION_CRUD_ENSEIGNANTS_PATH);
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $statut = $_POST["statut"];

            try {
                $nouvelEnseignant = new Enseignant($idEnseignant, $nom, $prenom, $statut);
                modifierEnseignant($nouvelEnseignant);
                print("
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Succès !</strong>
                        <p>L'enseignant a bien été modifié.</p>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        ");
            } catch (Exception $e) {
                // Afficher l'erreur      
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo $e->getMessage();
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                echo '</div>';
            }
        }



        $enseignant = recupererUnEnseignant($idEnseignant);

        echo '
        <form action="' . PAGE_MODIFIER_ENSEIGNANT_PATH . '" method="post">
        <div class="form-group row">
            <label for="nom" class="col-4 col-form-label">Nom</label>
            <div class="col-8">
            <div class="input-group">
                <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fa fa-address-card"></i>
                </div>
                </div>
                <input id="nom" name="nom" placeholder="ex : DUPONT" type="text" 
                class="form-control" value="' . $enseignant->getNom() . '"
                required="required">
            </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="prenom" class="col-4 col-form-label">Prénom</label>
            <div class="col-8">
            <div class="input-group">
                <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fa fa-address-card"></i>
                </div>
                </div>
                <input id="prenom" name="prenom" placeholder="ex : Paul" type="text"
                class="form-control" value="' . $enseignant->getPrenom() . '"
                required="required">
            </div>
            </div>
        </div>';

        // Statut
        if ($enseignant->getEstTitulaire()){
            echo '
            <div class="form-group row">
                <label for="statut" class="col-4 col-form-label">Statut</label>
                <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-address-card"></i>
                    </div>
                    </div>
                    <select id="statut" name="statut" class="custom-select" required="required">
                        <option value="Titulaire" selected>Titulaire</option>
                        <option value="Vacataire">Vacataire</option>
                    </select>
                </div>
                </div>
            </div>';
        }
        else{
            echo '
            <div class="form-group row">
                <label for="statut" class="col-4 col-form-label">Statut</label>
                <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-address-card"></i>
                    </div>
                    </div>
                    <select id="statut" name="statut" class="custom-select" required="required">
                        <option value="Titulaire">Titulaire</option>
                        <option value="Vacataire" selected>Vacataire</option>
                    </select>
                </div>
                </div>
            </div>';
        }
        
echo '
        <div class="form-group row">
            <input name="idEnseignant" value="' . $idEnseignant . '" hidden></input>
        </div>
        <div class="offset-4 col-8">
            <button name="submit" type="submit" class="btn btn-primary">Modifier</button>
        </div>
        
        </form>

        ';
    }
    else{
        echo "Aucun étudiant n'a été renseigné. Veuillez-réessayer";    
    }
    ?>


  </div>
  <div class="col-3"></div>
</div>