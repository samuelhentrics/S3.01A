<div class="container">

        <?php

        echo '
        <h2>
            <form action="'.PAGE_UTILISATEURS_PATH.'" method="post" style="display:inline;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </button>
            </form>
            Editer mon profil
        </h2><br>';

        if (isset($_POST['submit'])) {
            include_once(FONCTION_CRUD_UTILISATEURS_PATH);
            include_once(CLASS_PATH . CLASS_UTILISATEUR_FILE_NAME);
            include_once(IMPORT_PATH . "connexion.php");

            try {
                $unUtilisateur = recupererUtilisateur($_SESSION['id']);
                $id = $_SESSION["id"];
                $nom = $_SESSION["nom"];
                $prenom = $_SESSION["prenom"];
                $role = $_SESSION["role"];
                $mail = $_SESSION["email"];
                if(!(empty($_POST['password']) || empty($_POST['password2']))){
                    $mdp = htmlspecialchars($_POST['password']);
                    $mdp2 = htmlspecialchars($_POST['password2']);


                    if ($mdp != $mdp2)
                        throw new Exception("Les mots de passe ne correspondent pas.");

                    $mdp = hashPassword($mdp);

                    $mdpChangePhrase = "Le mot de passe a été modifié.";
                }
                else{
                    $mdpChangePhrase = "";
                }

                $nouvelUtilisateur = new Utilisateur($id, $nom, $prenom, $role, $mail, $mdp);
                modifierUtilisateur($unUtilisateur, $nouvelUtilisateur);
                echo "<div class='alert alert-success' role='alert'>L'utilisateur a bien été modifié. $mdpChangePhrase</div>";

            } catch (Exception $e) {
                echo "<div class='alert alert-danger' role='alert'>
                L'utilisateur n'a pas été modifié : " . $e->getMessage() . "</div>";
            }
        }
        ?>


        <div class="col-3"></div>
        <div class="col-6 m-auto text-center">
        <?php
        // Afficher l'avatar du profil
        echo '<img src="' . IMG_PATH . $_SESSION["avatar"] . '" class="img-fluid" alt="Responsive image" style="max-width: 200px; max-height: 200px; border-radius: 50%;"><br><br>';
        // Nom et prénom
        echo '<h3>' . $_SESSION["nom"] . ' ' . $_SESSION["prenom"] . '</h3>';
        // Rôle
        switch($_SESSION["role"]){
            case 0:
                echo '<h5>Administrateur</h5>';
                break;
            case 1:
                echo '<h5>Secrétaire/Administrateur</h5>';
                break;
            case 2:
                echo '<h5>Secrétaire</h5>';
                break;
            default:
                echo '<h5>Erreur</h5>';
                break;
        }

        // Mail
        echo '<h5>' . $_SESSION["email"] . '</h5>';
        ?>
        
        <form action="<?php echo PAGE_PROFIL_PATH; ?>" method="post">
                

                <div class="form-group row">
                    <label for="password" class="col-4 col-form-label">Nouveau mot de passe</label>
                    <div class="col-8">
                        <div class="input-group">
                            <input id="password" name="password" placeholder="ex: 1234" type="password" class="form-control"
                              value=""  >
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password2" class="col-4 col-form-label">Confirmation du mot de passe</label>
                    <div class="col-8">
                        <div class="input-group">
                            <input id="password2" name="password2" placeholder="ex: 1234" type="password" class="form-control"
                               value="" >
                        </div>
                    </div>
                </div>

                <div class="offset-4 col-8">
                    <button name="submit" type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
    (*) signifie obligatoire
</div>
