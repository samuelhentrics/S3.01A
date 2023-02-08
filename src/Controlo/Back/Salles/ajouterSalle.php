<div class="container">
    <div class="col-3"></div>
    <div class="col-6 m-auto text-center">
        <h2>Ajouter une salle</h2>
        <br>
        <form action=<?php echo PAGE_AJOUTER2_SALLE_PATH; ?> method="post">
            <div class="form-group row">
                <label for="nom" class="col-4 col-form-label">Nom de salle pour génération</label>
                <div class="col-8">
                    <div class="input-group">
                        <input id="nomSalle" name="nomSalle" placeholder="Ex : S124" type="text" class="form-salle"
                            required="required">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="salleVoisine" class="col-4 col-form-label">Salle voisine</label>
                <div class="col-8">
                    <!-- à refaire car il s'agit d'une liste déroulante -->
                    <div class="input-group">
                        <input id="salleVoisine" name="salleVoisine" placeholder="Ex: S125" type="text"
                            class="form-salle" required="required">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="nbrLigne" class="col-4 col-form-label">Nombre de lignes</label>
                <div class="col-8">
                    <div class="input-group">
                        <input id="nbrLigne" name="nbrLigne" placeholder="Ex: 5" type="number" class="form-salle"
                            required="required">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="nbrColonne" class="col-4 col-form-label">Nombre de colonnes</label>
                <div class="col-8">
                    <div class="input-group">
                        <input id="nbrColonne" name="nbrColonne" placeholder="Ex: 6" type="number" class="form-salle"
                            required="required">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-8">
                    <button name="submit" type="submit" class="btn btn-primary">Créer le plan de la
                        salle</button>
                </div>
            </div>

        </form>
    </div>
    <div class="col-3"></div>
</div>