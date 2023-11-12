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

// Get user details from user and user_input tables
$sql = "SELECT u.sex, u.age, u.country, ui.purpose, ui.period 
        FROM user u 
        INNER JOIN user_input ui ON u.ID = ui.UserID";

// Prepare statement
$stmt = $conn->prepare($sql);

// Execute the statement
$stmt->execute();

// Bind the result variables
$stmt->bind_result($gender, $age, $country, $purpose, $period);

// Fetch the data
while ($stmt->fetch()) {
  // Prepare the SQL statement for travel_info
  $sql_travel = "SELECT AVG(avg_expense_per_person), AVG(avg_expense_per_day) 
                 FROM travel_info 
                 WHERE gender = ? AND age = ? AND country_of_origin = ? AND main_activity = ? AND visit_duration = ?";

  // Prepare statement for travel_info
  $stmt_travel = $conn->prepare($sql_travel);
  $stmt_travel->bind_param("sisss", $gender, $age, $country, $purpose, $period);

  // Execute the statement for travel_info
  $stmt_travel->execute();

  // Bind the result variables for travel_info
  $stmt_travel->bind_result($avg_per_person, $avg_per_day);

  // Fetch the data for travel_info
  while ($stmt_travel->fetch()) {
    // Print the result
    echo "성별: $gender, 나이: $age, 출신국가: $country, 주요 활동: $purpose, 방문기간: $period, 1인당 여행 경비 평균: $avg_per_person, 1일당 여행 경비 평균: $avg_per_day <br>";
  }

  // Close the statement for travel_info
  $stmt_travel->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Expense Visualization</title>
    <link href="/static/css/text-style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Travel Expense Visualization</h2>
<canvas id="expenseChart" width="400" height="400"></canvas>

<script>
// 데이터 가공
var genders = [];
var avgPerPersonData = [];
var avgPerDayData = [];

<?php
// 쿼리 결과로부터 데이터를 추출하여 JavaScript 변수에 할당
while ($stmt->fetch()) {
    echo "genders.push('$gender');";
    echo "avgPerPersonData.push($avg_per_person);";
    echo "avgPerDayData.push($avg_per_day);";
}
?>

var expenseCtx = document.getElementById('expenseChart').getContext('2d');
var expenseChart = new Chart(expenseCtx, {
    type: 'bar',
    data: {
        labels: genders,
        datasets: [{
            label: '1인당 여행 경비 평균',
            data: avgPerPersonData,
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        },
        {
            label: '1일당 여행 경비 평균',
            data: avgPerDayData,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>