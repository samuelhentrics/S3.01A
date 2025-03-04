<div class="container">
    <div class="col-12">
        <br>

        <script>
            var lien = "<?php echo JS_PATH ?>";
            $(document).ready(function () {
                $('#promotions').DataTable({
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
                    <h1>Liste des promotions</h1>
                </div>
                <div class="col-4 text-end">
                    <a href="<?php echo PAGE_AJOUTER_PROMOTION_PATH; ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Ajouter
                    </a>
                    <a href="<?php echo PAGE_IMPORTER_PROMOTION_PATH; ?>" class="btn btn-primary">
                        <i class="fas fa-file-import"></i>
                        Importer
                    </a>
                </div>
            </div>

            <table  id="promotions" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nom de la promotion</th>
                        <th>Nom pour génération</th>
                        <th>Effectif de la promotion</th>
                        <th>Effectif d'étudiants avec tiers-temps</th>
                        <th>Nombre d'étudiants avec ordinateur</th>
                        <th>Nombre d'étudiants démissionnaires</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    include(FONCTION_CREER_LISTE_PROMOTIONS_PATH);

                    $listePromotions = creerListePromotions(true);

                    foreach ($listePromotions as $unePromotion) {



                        // Nom de la promotion
                        $nomPromotion = $unePromotion->getNom();

                        // Récupérer le nom pour affichage de la promotion
                        $nomPromotionAffichage = $unePromotion->getNomAffichage();

                        // Compter le nombre d'étudiants dans la promotion
                        $effectifEtudiant = count($unePromotion->getMesEtudiants());

                        // Compter le nombre d'étudiants Tiers-Temps dans la promotion
                        $nbEtudiantTT = count($unePromotion->getMesEtudiants()) - count($unePromotion->recupererListeEtudiantsNonTT());

                        // Compter le nombre d'étudiants avec ordinateur dans la promotion
                        $nbEtudiantsOrdi = count($unePromotion->recupererListeEtudiantsOrdi());

                        // Compter le nombre d'étudiants démisionnaires dans la promotion
                        $nbEtudiantDemisionnaire = count($unePromotion->recupererListeEtudiantsDemisionnaire());




                        // Etudiant démisionnaires
                    

                        print("

                        <tr>
                            <td>" . $nomPromotion . "</td>
                            <td>" . $nomPromotionAffichage . "</td>
                            <td>" . $effectifEtudiant . "</td>
                            <td>" . $nbEtudiantTT . "</td>
                            <td>" . $nbEtudiantsOrdi . "</td>
                            <td>" . $nbEtudiantDemisionnaire . "</td>
                        <td class=\"text-center\">
                            <form style='display:inline;' method=\"post\" action=" . PAGE_MODIFIER_PROMOTION_PATH . ">
                                <input type=\"hidden\" name=\"nomPromotion\" value=\"" . $nomPromotion . "\">
                                <button type=\"submit\" class=\"btn btn-primary\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Modifier\">
                                    <i class=\"fas fa-edit\"></i>
                                </button>
                                </form>
                            <form style='display:inline;' method=\"post\" action=" . PAGE_SUPPRIMER_PROMOTION_PATH . ">
                                <input type=\"hidden\" name=\"nomPromotion\" value=\"" . $nomPromotion . "\">

                                <button type=\"submit\" onclick=\"return confirm('Confirmer la suppression de: ".$nomPromotion."')\" name=\"action\" class=\"btn btn-danger\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Supprimer\">
                                    <i class=\"fas fa-trash-alt\"></i>
                                </button>
                            </form>
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