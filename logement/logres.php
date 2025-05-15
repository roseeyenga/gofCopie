<?php require('logement.php'); ?>

<?php if (count($logements) > 0): ?>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Localisation</th>
                <th>Pièces disponibles</th>
                <th>Prix (FCFA)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logements as $index => $logement): ?>
                <tr>
                    <td><?php echo htmlspecialchars($logement['localisation']); ?></td>
                    <td><?php echo htmlspecialchars($logement['nombre_de_pieces_disponibles']); ?></td>
                    <td><?php echo htmlspecialchars($logement['prix']); ?></td>
                    <td>
                        <button id="reserver" onclick="openModal(<?php echo $index; ?>)">Réserver</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modales pour chaque logement -->
    <?php foreach ($logements as $index => $logement): ?>
        <div class="modal" id="modal-<?php echo $index; ?>">
            <div class="modal-content">
                <span class="close" onclick="closeModal(<?php echo $index; ?>)">&times;</span>
                <h2>Réserver à <?php echo htmlspecialchars($logement['localisation']); ?></h2>
                <form method="POST" action="traitementresvlo.php">
                    <input type="hidden" name="idl" value="<?php echo htmlspecialchars($logement['idl']); ?>">
                    <input type="hidden" class="prix-unitaire" value="<?php echo htmlspecialchars($logement['prix']); ?>">

                    <label>identifiant :</label>
                    <input type="int" name="id" required><br>

                    <label>Nombre de pièces souhaitées :</label>
                    <input type="number"
                        name="nb_pieces"
                        class="nb-pieces"
                        min="1"
                        max="<?php echo htmlspecialchars($logement['nombre_de_pieces_disponibles']); ?>"
                        required><br>

                    <p><strong>Prix total :</strong> <span class="prix-total"></span> FCFA</p>
                    <input type="hidden" name="prix" class="prix-hidden" id="prix">

                    <button type="submit">Confirmer la réservation</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Style CSS pour la modale -->
    <style>

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px; right: 15px;
            color: #aaa;
            font-size: 24px;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        input, button {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border-radius: 5px;
        }

        button {
            background-color: #2e7d32;
            color: white;
            border: none;
        }

        button:hover {
            background-color: #1b5e20;
        }

        .tbody {
            background-color: rgb(45, 118, 226);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }
    </style>

    <!-- Script JS pour gérer les modales -->
    <script>
        function openModal(index) {
            document.getElementById('modal-' + index).style.display = 'block';
        }
        document.querySelectorAll('.modal').forEach(function(modal) {
            const nbPiecesInput = modal.querySelector('.nb-pieces');
            const prixUnitaire = parseInt(modal.querySelector('.prix-unitaire').value);
            const prixTotalSpan = modal.querySelector('.prix-total');


            if (nbPiecesInput) {
                nbPiecesInput.addEventListener('input', function () {
                    const nb = parseInt(this.value);
                    if (!isNaN(nb) && nb >= 1) {
                        const total = nb * prixUnitaire;
                        prixTotalSpan.textContent = total.toLocaleString(); // Affiche avec séparateurs (1 000 000)
                        
                    } else {
                        prixTotalSpan.textContent = '0';
                    }
                });
            }
        });


                // Lors du clic sur "Réserver"
        a = ducument.getElementById("reserver");
        a.addEventListener("click", function () {
        const logementId = this.dataset.logementId; // par exemple
        document.querySelector("#formulaireReservation input[name='idl']").value = logementId;
        });

        function closeModal(index) {
            document.getElementById('modal-' + index).style.display = 'none';
        }

        // Fermer en cliquant hors de la modale
        window.onclick = function(event) {
            document.querySelectorAll('.modal').forEach(function(modal) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        };


        document.addEventListener('DOMContentLoaded', function () {
            
            // Pour chaque formulaire de réservation sur la page
            document.querySelectorAll('form').forEach(function(form) {
                const nbPiecesInput = form.querySelector('.nb-pieces');
                const prixUnitaireInput = form.querySelector('.prix-unitaire');
                const prixTotalSpan = form.querySelector('.prix-total');
                const prixHiddenInput = document.getElementById('prix');

                function updatePrix() {
                const nbPieces = parseInt(nbPiecesInput.value) || 0;
                const prixUnitaire = parseInt(prixUnitaireInput.value) || 0;
                const total = nbPieces * prixUnitaire;


                prixTotalSpan.textContent = total;
                documentgetElementById("prix").value = total;
                prixHiddenInput.value = total;

                }

                nbPiecesInput.addEventListener('input', updatePrix);
                updatePrix(); // calcul initial si besoin
            });
        });
        
    </script>
<?php else: ?>
    <p>Aucun logement trouvé dans la base de données.</p>
<?php endif; ?>


