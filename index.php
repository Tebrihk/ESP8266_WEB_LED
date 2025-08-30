<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "esp8266_leds";
$conn = new mysqli($host, $user, $pass, $dbname);

$result = $conn->query("SELECT * FROM leds ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ESP8266 LED Control</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="container py-4">

  <h1 class="mb-4 text-center">ESP8266 LED Control Panel</h1>
  <div class="row">
    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="col-md-3 text-center mb-4">
        <h5>LED <?php echo $row['id']; ?></h5>
        <div class="form-check form-switch d-flex justify-content-center">
          <input class="form-check-input led-toggle" type="checkbox" 
                 data-id="<?php echo $row['id']; ?>" 
                 <?php if ($row['state'] == 1) echo "checked"; ?>>
        </div>
      </div>
    <?php } ?>
  </div>

  <script>
    $(document).ready(function(){
      $(".led-toggle").change(function(){
        var ledId = $(this).data("id");
        var state = $(this).is(":checked") ? 1 : 0;

        $.get("ESP8266_LEDs.php", { led: ledId, state: state });
      });
    });
  </script>

</body>
</html>
