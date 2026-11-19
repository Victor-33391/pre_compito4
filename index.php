<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mini-carrello</title>
  <style>
    body {
      font-family: sans-serif;
      max-width: 32rem;
      margin: 2rem auto;
      padding: 0 1rem;
      color: #1c1e22;
      background: #f7f6f2;
    }

    h1 {
      margin-bottom: 0.2rem;
    }

    .negozio {
      margin-top: 0;
      color: #555b66;
    }

    form {
      background: #fff;
      border: 1px solid #d6d3cb;
      border-radius: 8px;
      padding: 1rem 1.2rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      text-align: left;
      padding: 0.4rem 0.3rem;
      border-bottom: 1px solid #e6e3dc;
    }

    td.prezzo {
      white-space: nowrap;
    }

    input[type="number"] {
      width: 4rem;
    }

    fieldset {
      margin: 1rem 0;
      border: 1px solid #d6d3cb;
      border-radius: 6px;
    }

    label {
      display: block;
      margin: 0.3rem 0;
    }

    button {
      font-size: 1rem;
      padding: 0.5rem 1.2rem;
      border: 0;
      border-radius: 6px;
      background: #1f5fbf;
      color: #fff;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <h1>Mini-carrello</h1>
  <p class="negozio">Cartoleria TPSIT</p>

  <form action="carrello.php" method="post">
    <!-- prodotti: un campo quantità per ogni prodotto (0 = non lo compro) -->
    <table>
      <thead>
        <tr>
          <th>Prodotto</th>
          <th>Prezzo</th>
          <th>Quantità</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><label for="quaderno">Quaderno</label></td>
          <td class="prezzo">2,50 €</td>
          <td><input type="number" id="quaderno" name="quaderno" value="0" min="0"></td>
        </tr>
        <tr>
          <td><label for="penna">Penna</label></td>
          <td class="prezzo">1,20 €</td>
          <td><input type="number" id="penna" name="penna" value="0" min="0"></td>
        </tr>
        <tr>
          <td><label for="zaino">Zaino</label></td>
          <td class="prezzo">35,00 €</td>
          <td><input type="number" id="zaino" name="zaino" value="0" min="0"></td>
        </tr>
      </tbody>
    </table>

    <!-- checkbox: zero, uno o due extra; con [] arrivano in un array -->
    <fieldset>
      <legend>Extra</legend>
      <label><input type="checkbox" name="extra[]" value="regalo"> confezione regalo (+3,00 €)</label>
      <label><input type="checkbox" name="extra[]" value="express"> spedizione express (+7,00 €)</label>
    </fieldset>

    <label>Codice sconto: <input type="text" name="codice"></label>

    <p><button type="submit">Calcola il totale</button></p>
  </form>

  <?php
    
    if (isset($_POST['quaderno'])) {
        $q_quaderno = $_POST['quaderno'];
    } else {
        $q_quaderno = 0;
    }

    if (isset($_POST['penna'])) {
        $q_penna = $_POST['penna'];
    } else {
        $q_penna = 0;
    }

    if (isset($_POST['zaino'])) {
        $q_zaino = $_POST['zaino'];
    } else {
        $q_zaino = 0;
    }

    
    if ($q_quaderno == 0 && $q_penna == 0 && $q_zaino == 0) {
        echo "<p>Il carrello è vuoto</p>";
    } else {
        $subtotale = 0;

        // 1. Calcolo e stampa dei prodotti con quantità > 0[cite: 1]
        if ($q_quaderno > 0) {
            $tot = $q_quaderno * 2.50;
            $subtotale = $subtotale + $tot;
            echo "<p>Quaderno: $q_quaderno x 2,50 € = " . number_format($tot, 2, ',', '.') . " €</p>";
        }
        if ($q_penna > 0) {
            $tot = $q_penna * 1.20;
            $subtotale = $subtotale + $tot;
            echo "<p>Penna: $q_penna x 1,20 € = " . number_format($tot, 2, ',', '.') . " €</p>";
        }
        if ($q_zaino > 0) {
            $tot = $q_zaino * 35.00;
            $subtotale = $subtotale + $tot;
            echo "<p>Zaino: $q_zaino x 35,00 € = " . number_format($tot, 2, ',', '.') . " €</p>";
        }

        echo "<p>Subtotale: " . number_format($subtotale, 2, ',', '.') . " €</p>";

        
        if (isset($_POST['sconto'])) {
            $codice = $_POST['sconto'];
        } else {
            $codice = '';
        }

        if ($codice != '') {
            if ($codice == 'KTM50') {
                $subtotale = $subtotale * 0.50; // -50%
                echo "<p>Sconto KTM50 applicato (-50%)</p>";
            } elseif ($codice == 'KTSM80') {
                $subtotale = $subtotale * 0.20; // -80%
                echo "<p>Sconto KTSM80 applicato (-80%)</p>";
            } else {
                echo '<p class="error">Codice sconto non valido</p>';
            }
        }

        
        $extra = 0;
        if (isset($_POST['regalo'])) {
            $extra = $extra + 3;
            echo "<p>Confezione regalo: +3,00 €</p>";
        }
        if (isset($_POST['express'])) {
            $extra = $extra + 7;
            echo "<p>Spedizione express: +7,00 €</p>";
        }

        
        $totale = $subtotale + $extra;
        echo "<h3>Totale: " . number_format($totale, 2, ',', '.') . " €</h3>";
    }
?>
</body>

</html>