<?php
// Define as configurações do banco de dados
$host = '127.0.0.1';
$database = 'arduino';
$username = 'root';
$password = '';

// Cria a conexão com o banco de dados usando PDO
$connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Dados do Arduino</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-OgVRvuATP1z7JjHLkuOUzXw6Adb2gZiEPTFwTOEpA2+nKg4FfjlBk9t8hB4jcPV4" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" />
  <script src="https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"></script>
</head>

<body>
  <div class="container">
    <h1>
      <center>Dados do Arduino</center>
    </h1>
    <div class="card">
      <div class="card-body">
        <table id="tabela" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Temperatura</th>
              <th>Umidade</th>
              <th>Data e Hora</th>
            </tr>
          </thead>
          <tbody id="dados">
            <?php
            try {
              $SQL = "SELECT * FROM dados ORDER BY id DESC";
              $result = $connection->query($SQL);
              $result->setFetchMode(PDO::FETCH_ASSOC);
              $dados = $result->fetchAll();
              foreach ($dados as $row) {
                echo "<tr>";
                echo "<td>" . $row['temperatura'] . 'C°' . "</td>";
                echo "<td>" . $row['umidade'] . ' (g/m³)' . "</td>";
                echo "<td>" . date('d/m/Y H:i:s', strtotime($row['tms_cadastro'])) . "</td>";

                echo "</tr>";
              }
            } catch (PDOException $e) {
              echo $e->getMessage();
            }


            ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#tabela').DataTable({

      });


    });
  </script>
</body>

</html>