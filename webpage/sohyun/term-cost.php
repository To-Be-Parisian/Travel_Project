<?php
$servername = "localhost";
$username = "root";
$password = "thgus201";
$dbname = "php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$sql = "SELECT visit_duration, avg_expense_per_person, avg_expense_per_day FROM travel_amount";

$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link href="/static/css/home.css" rel="stylesheet" />

  <link href="/static/css/term-cost.css" rel="stylesheet" />

  <link href="/static/css/text-style.css" rel="stylesheet" />
</head>
<body>
  <h2>Expense Based On Term</h2>
  <center-item>
  <div class="statics-chart">
    <canvas id="myChart"></canvas>
  </div>
  </center-item>
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_column($data, 'visit_duration')); ?>,
      datasets: [{
        label: "Expense per person",
        data: <?php echo json_encode(array_column($data, 'avg_expense_per_person')); ?>,
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1
      }, {
        label: 'Expense per day',
        data: <?php echo json_encode(array_column($data, 'avg_expense_per_day')); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        x: {
          type: 'category',
          labels: <?php echo json_encode(array_column($data, 'visit_duration')); ?>
        },
        y: {
          beginAtZero: true
        }
      }
    }
    }
  );
</script>
</body>
</html>
