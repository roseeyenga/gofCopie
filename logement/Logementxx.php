
<?php require('logement.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoFind</title>
  <style>

    .search-bar {
      border-radius: 25px;
      display: flex;
      align-items: center;
      width: 400px;
    }
    .search-bar input {
      background: transparent;
      border: none;
      outline: none;
      color: #ccc;
      font-size: 16px;
      flex: 1;
      margin-left: 10px;
    }
    .search-bar .icon {
      color: #aaa;
      font-size: 18px;
    }

    .btn1 {
      display: flex;
      align-items: center;
      width: 40px;
      height:40px;
      padding: 12px;
      margin-top: 10px;
      border: none;
      border-radius: 8px;
      background-color: #000;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      
    }
    .body {
      background-color: rgb(45, 118, 226);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      width: 90%;
      max-width: 400px;
      text-align: center;
    }

    .icons {
      display: flex;
      justify-content: space-around;
      margin-bottom: 20px;
    }

    .icons img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: #fff;
      padding: 5px;
    }

    h1 {
      margin-bottom: 10px;
    }

    input[type="email"], input[type="password"], input[type="text"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background-color: #f0f0f0;
    }

    .btn {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: none;
      border-radius: 8px;
      background-color: #000;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }

    .separator {
      margin: 20px 0;
      position: relative;
    }

    .separator::before,
    .separator::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 45%;
      height: 1px;
      background: #ccc;
    }

    .separator::before {
      left: 0;
    }

    .separator::after {
      right: 0;
    }

    .separator span {
      background: white;
      padding: 0 10px;
      position: relative;
      z-index: 1;
    }

    .section-title {
      font-weight: bold;
      font-size: 1.2em;
    }
  </style>
  <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
</head>
<body>
  
      <div class="icons">
          <!-- Fix the path to the image -->
          <img src="images/WhatsAppImage.jpg" alt="Logement">  <!-- Replace with the correct relative path -->
      </div>

      <h1>GoFind</h1>

      <div class="search-bar">
          <i class="fas fa-search icon"></i>
          <input type="text" placeholder="Rechercher un trajet">
          <button class="btn1">OK</button>
      </div>

      <h1>Liste des Logements</h1>
      <?php if (count($logements) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Adresse</th>
                <th>Pièces disponibles</th>
                <th>Prix (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logements as $logement): ?>
                <tr>
                    <td><?php echo htmlspecialchars($logement['localisation']); ?></td>
                    <td><?php echo htmlspecialchars($logement['nombre_de_pieces_disponibles']); ?></td>
                    <td><?php echo htmlspecialchars($logement['prix']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <?php foreach ($logements as $index => $logement): ?>
                <tr>
                    <td><?php echo htmlspecialchars($logement['localisation']); ?></td>
                    <td><?php echo htmlspecialchars($logement['pieces']); ?></td>
                    <td><?php echo htmlspecialchars($logement['prix']); ?></td>
                    <td>
                        <button class="btn" onclick="toggleForm(<?php echo $index; ?>)">Réserver</button>
                    </td>
                </tr>
                <!-- Formulaire caché au départ -->
                <tr id="form-row-<?php echo $index; ?>" style="display: none;">
                    <td colspan="4">
                        <form method="POST" action="traitement_reservation.php">
                            <input type="hidden" name="idl" value="<?php echo htmlspecialchars($logement['idl']); ?>">
                            <label>identifiant utilisateur :</label>
                            <input type="int" name="id" required><br>
                            <input type="hidden" id="prix_unitaire" value="<?php echo htmlspecialchars($logement['prix']); ?>">

                            <label>prix:</label>
                            <input type="number" name="prix"  id="prix" readonly><br>
                            <label>Nombre de pièces souhaitées :</label>
                            <input type="int" name="nb_pieces" min="1" max="<?php echo htmlspecialchars($logement['Nombre_de_pieces_disponibles']); ?>" required><br>
                            <button type="submit">Envoyer la réservation</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        function toggleForm(index) {
            const row = document.getElementById('form-row-' + index);
            if (row.style.display === 'none') {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }

     
      document.addEventListener('DOMContentLoaded', function () {
        const nbPiecesInput = document.getElementById('nb_pieces');
        const prixInput = document.getElementById('prix');
        const prixUnitaireInput = document.getElementById('prix_unitaire');

        function calculerPrix() {
          const nbPieces = parseInt(nbPiecesInput.value) || 0;
          const prixUnitaire = parseInt(prixUnitaireInput.value) || 0;
          const total = nbPieces * prixUnitaire;
          prixInput.value = total;
        }

        // recalcul à chaque changement de nombre de pièces
        nbPiecesInput.addEventListener('input', calculerPrix);

        // recalcul au chargement si nécessaire
        calculerPrix();
      });
    

    </script>
    </table>
<?php else: ?>
    <p>Aucun logement trouvé dans la base de données.</p>
<?php endif; ?>


      <a href="FsignLogement.html"><button class="btn">Signaler un logement</button></a>
      <a href="Menu.html"><button class="btn">Retour</button></a>
  
</body>
</html>