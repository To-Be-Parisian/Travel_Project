<?php

include "./db.php"; // 데이터베이스 연결 설정 파일

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


    // Prepare the SQL statement for travel_info with JOIN
    $sql_travel = "SELECT 
    AVG(ti.avg_expense_per_person) AS avg_expense_per_person,
    AVG(ti.avg_expense_per_day) AS avg_expense_per_day
    FROM user_input ui
    JOIN travel_info ti ON ti.main_activity = ui.purpose
    WHERE ui.UserID = ?
    GROUP BY ui.purpose";


    // Prepare statement for travel_info
    $stmt_travel = $db->prepare($sql_travel);
    $stmt_travel->bind_param("i", $_SESSION['userid']);

    // Execute the statement for travel_info
    if (!$stmt_travel->execute()) {
        error_log("Error in travel_info statement execution: " . $stmt_travel->error);
        die("Error in travel_info statement execution. Please check the error log for details.");
    }

    // Bind the result variables for travel_info
    $stmt_travel->bind_result($avg_per_person, $avg_per_day);
    
    if ($stmt_travel->fetch()) {
    } else {
        echo "No data found.";
    }
    $stmt_travel->close();

    // Close the database connection
    $db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Expense Visualization</title>
    <link href="./static/css/text-style.css" rel="stylesheet" />
    <link href="./static/css/cost-prediction.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <h2 style="text-align : center;">Travel Expense Visualization</h2>
    <center-item>
        <div class="static-chart">
            <canvas id="expenseChart" width=1000" height="600"></canvas>
        </div>
    </center-item>

    <script>
    // 데이터 가공
    var avgPerPersonData = <?php echo json_encode($avg_per_person); ?>;
    var avgPerDayData = <?php echo json_encode($avg_per_day); ?>;


    var expenseCtx = document.getElementById('expenseChart').getContext('2d');
    var expenseChart = new Chart(expenseCtx, {
        type: 'bar',
        data: {
            labels: ['Expense'], // Assuming there is only one category
            datasets: [{
                    label: 'Expense Per Person',
                    data: avgPerPersonData,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Expense Per Day',
                    data: avgPerDayData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
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