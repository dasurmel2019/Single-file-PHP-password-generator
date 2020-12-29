<?php
// Settings
$settings = [
  "max_length" => 500, // maximale länge je Passwort
  "max_amount" => 100, // maximale Anzahl an zu generierenden Passwörtern je Anfrage
  "contentOfPasswords" => "123456789ABCDEFGHJKMNOPQRSTUVWXYZ" // für Passwörter zu verwendene Zeichen
];

$showResult = false;

// Funktion zur Passworterstellung
function generatePassword($length = 20, $amount = 2)
{
  global $settings;
  $content = $settings["contentOfPasswords"];

  $str = "";
  $str_length = strlen($content);

  $k = 0;
  while ($k <= $amount-1)
  {
    $k++;
    for ($i = 0; $i < $length; $i++)
    {
      $str .= $content[rand(0,$str_length-1)];
    }
    echo "$str\n";
    $str = "";
  }
}

if (!empty($_GET["action"]) AND $_GET["action"] == "generate") {
  $length = $_POST["length"];
  $amount = $_POST["amount"];
  if (empty($_POST['length'])) {
    $length = 10;
  } else {
    if ($length > $settings["max_length"]) {
      $length = $settings["max_length"];
    }
  }
  if (empty($_POST['amount'])) {
    $amount = 2;
  } else {
    if ($amount > $settings["max_amount"]) {
      $amount = $settings["max_amount"];
    }
  }
  $showResult = true;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Passwortgenerator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
  <div class="container-sm mt-5">
    <h2><a href="index.php" class="link-dark text-decoration-none">Passwortgenerator</a></h2>
    <div class="card mb-3">
      <div class="card-header">
        Einstellungen
      </div>
      <div class="card-body">
        <form method="post" action="?action=generate">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="length" class="form-label">Länge des Passworts/der Passwörter</label>
                <input type="number" class="form-control" id="length" value="<?php if($showResult) { echo $length; } else { echo "10"; } ?>" name="length" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Anzahl der zu generierenden Passwörter</label>
                <input type="number" class="form-control" id="amount" value="<?php if($showResult) { echo $amount; } else { echo "2"; } ?>" name="amount" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3 d-grid">
                <input type="submit" value="Generieren" class="btn btn-primary">
              </div>
            </div>
          </div>
      </div>
    </form>
  </div>
  <?php if($showResult) { ?>
  <div class="card">
    <div class="card-header">
      Ergebnis
    </div>
    <div class="card-body d-grid">
      <textarea class="form-control" rows="5"><?php generatePassword($length, $amount); ?></textarea>
      <button class="btn btn-success mt-3"><?php if ($amount > 1) { echo "Passwörter kopieren"; } else { echo "Passwort kopieren"; } ?></button>
    </div>
  </div>
  <?php } ?>
  </div>
  <script type="text/javascript">
  document.querySelector("button").onclick = function(){
  document.querySelector("textarea").select();
  document.execCommand('copy');
  };
  </script>
</body>
</html>
