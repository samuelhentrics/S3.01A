<div class="container">
    <div class="col-12">
        <br>

        <script>
            var lien = "<?php echo JS_PATH ?>";
            $(document).ready(function () {
                $('#utilisateurs').DataTable({
                    "language": {
                        "url": lien + "/French.json"
                    },

                    order: [
                        [0, 'asc'],
                        [1, 'asc']
                    ]
                });
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <section>
            <div class="row">
                <div class="col-8">
                    <h1>Liste des Utilisateurs</h1>
                </div>
                <div class="col-4 text-end">
                    <a href="<?php echo PAGE_AJOUTER_UTILISATEUR_PATH; ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Ajouter
                    </a>
                </div>
            </div>

            <table  id="utilisateurs" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom de l'utilisateur</th>
                        <th>Prénom de l'utilisateur</th>
                        <th>Role de l'utilisateur</th>
                        <th>Mail de l'utilisateur</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    include(FONCTION_CREER_LISTE_UTILISATEURS_PATH);

                    $listeUtilisateurs = creerListeUtilisateurs(true);

                    foreach ($listeUtilisateurs as $unUtilisateur) {
                        // Photo de profil de l'utilisateur
                        $imgProfilUtilisateur = $unUtilisateur->getImgProfil();

                        // Id de l'utilisateur
                        $idUtilisateur = $unUtilisateur->getId();

                        // Nom de l'utilisateur
                        $nomUtilisateur = $unUtilisateur->getNom();

                        // Prenom de l'utilisateur
                        $prenomUtilisateur = $unUtilisateur->getPrenom();
                        
                        // role de l'utilisateur
                        $roleUtilisateur = $unUtilisateur->getRole();

                        // Mail de l'utilisateur
                        $mailUtilisateur = $unUtilisateur->getMail();

                        switch($roleUtilisateur){
                            case 0:$role='Administrateur';break;
                            case 1:$role='Secrétaire/Administrateur';break;
                            default: $role='Secrétaire';break;
                        };
                    

                        print("

                        <tr>
                            <td class='text-center'><img src=\"" . FRONT_PATH . IMG_FOLDER_NAME . $imgProfilUtilisateur . "\" alt=\"Photo de profil\" class=\"rounded-circle me-2\" style=\"width: 40px; height: 40px;\"></td>
                            <td>" . $nomUtilisateur . "</td>
                            <td>" . utf8_decode($prenomUtilisateur) . "</td>
                            <td>" . $role . "</td>
                            <td>" . $mailUtilisateur . "</td>
                        <td class=\"text-center\">" );

                            print("
                            <form style='display:inline;' method=\"post\" action=" . PAGE_MODIFIER_UTILISATEUR_PATH . ">
                            <input type=\"hidden\" name=\"idUtilisateur\" value=\"" . $idUtilisateur . "\">
                            <button type=\"submit\" class=\"btn btn-primary\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Modifier\">
                                <i class=\"fas fa-edit\"></i>
                            </button>
                            </form>");
                            
                            if($idUtilisateur != $_SESSION["id"]){
                            print("
                            <form style='display:inline;' method=\"post\" action=" . PAGE_SUPPRIMER_UTILISATEUR_PATH . ">
                            <input type=\"hidden\" name=\"idUtilisateur\" value=\"" . $idUtilisateur . "\">
                            
                            <button type=\"submit\" onclick=\"return confirm('Confirmer la suppression de: ".$nomUtilisateur."')\" name=\"action\" class=\"btn btn-danger\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Supprimer\">
                                <i class=\"fas fa-trash-alt\"></i>
                            </button>
                            </form>");
                            }

                        print("
                        </td>



                        </tr>");
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <br>
    </div>
</div>