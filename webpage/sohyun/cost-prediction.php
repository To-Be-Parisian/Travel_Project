<?php
include "db.php"; // 데이터베이스 연결 설정 파일

if (!isset($_SESSION['userid'])) {
    die("User not logged in.");
}

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get user details from user and user_input tables
$sql = "SELECT ui.purpose
        FROM user u 
        INNER JOIN user_input ui ON u.ID = ui.UserID 
        WHERE u.ID = ?"; 

// Prepare statement
$stmt = $db->prepare($sql);

// Bind the parameters
$stmt->bind_param("i", $_SESSION['userid']);

// Execute the statement
if (!$stmt->execute()) {
    error_log("Error in statement execution: " . $stmt->error);
    die("Error in statement execution. Please check the error log for details.");
}

// Bind the result variables
$stmt->bind_result($gender, $age, $country, $purpose, $period);

// Fetch the data
if ($stmt->fetch()) {
    // Prepare the SQL statement for travel_info with JOIN
    $sql_travel = "SELECT ti.avg_expense_per_person, ti.avg_expense_per_day 
    FROM travel_info ti
    JOIN user_input ui 
    AND ti.main_activity = ui.purpose
    WHERE ui.UserID = ?";

    // Close the statement for the main query
    $stmt->close();

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

    // Fetch the data for travel_info
    $stmt_travel->fetch();

    // Close the statement for travel_info
    $stmt_travel->close();
} else {
    echo "No user data found.";
}

// Close the database connection
$db->close();
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
        var genders = ['<?php echo $gender; ?>'];
        var avgPerPersonData = ['<?php echo $avg_per_person; ?>'];
        var avgPerDayData = ['<?php echo $avg_per_day; ?>'];

        var expenseCtx = document.getElementById('expenseChart').getContext('2d');
        var expenseChart = new Chart(expenseCtx, {
            type: 'bar',
            data: {
                labels: genders,
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
