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

// Prepare the SQL statement for travel_info with age condition
$sql_travel_age = "SELECT 
    AVG(ti.avg_expense_per_person) AS avg_expense_per_person_age,
    AVG(ti.avg_expense_per_day) AS avg_expense_per_day_age
    FROM user u
    JOIN travel_info ti ON ti.age = u.age
    WHERE u.ID = ?
    GROUP BY u.age";

// Prepare statement for travel_info with age condition
$stmt_travel_age = $db->prepare($sql_travel_age);
$stmt_travel_age->bind_param("i", $_SESSION['userid']);

// Execute the statement for travel_info with age condition
if (!$stmt_travel_age->execute()) {
    error_log("Error in travel_info statement execution: " . $stmt_travel_age->error);
    die("Error in travel_info statement execution. Please check the error log for details.");
}

// Bind the result variables for travel_info with age condition
$stmt_travel_age->bind_result($avg_per_person_age, $avg_per_day_age);

if ($stmt_travel_age->fetch()) {
} else {
    echo "No data found.";
}

$stmt_travel_age->close();

// Prepare the SQL statement for travel_info with period condition
$sql_travel_period = "SELECT 
    AVG(ti.avg_expense_per_person) AS avg_expense_per_person_period,
    AVG(ti.avg_expense_per_day) AS avg_expense_per_day_period
    FROM user_input ui
    JOIN travel_info ti ON ti.visit_duration = ui.period
    WHERE ui.UserID = ?
    GROUP BY ui.period";

// Prepare statement for travel_info with period condition
$stmt_travel_period = $db->prepare($sql_travel_period);
$stmt_travel_period->bind_param("i", $_SESSION['userid']);

// Execute the statement for travel_info with period condition
if (!$stmt_travel_period->execute()) {
    error_log("Error in travel_info statement execution: " . $stmt_travel_period->error);
    die("Error in travel_info statement execution. Please check the error log for details.");
}

// Bind the result variables for travel_info with period condition
$stmt_travel_period->bind_result($avg_per_person_period, $avg_per_day_period);

if ($stmt_travel_period->fetch()) {
} else {
    echo "No data found.";
}

$stmt_travel_period->close();

// Prepare the SQL statement for travel_info with gender condition
$sql_travel_gender = "SELECT 
    AVG(ti.avg_expense_per_person) AS avg_expense_per_person_gender,
    AVG(ti.avg_expense_per_day) AS avg_expense_per_day_gender
    FROM user u
    JOIN travel_info ti ON ti.gender = u.sex
    WHERE u.ID = ?
    GROUP BY u.sex";

// Prepare statement for travel_info with gender condition
$stmt_travel_gender = $db->prepare($sql_travel_gender);
$stmt_travel_gender->bind_param("i", $_SESSION['userid']);

// Execute the statement for travel_info with gender condition
if (!$stmt_travel_gender->execute()) {
    error_log("Error in travel_info statement execution: " . $stmt_travel_gender->error);
    die("Error in travel_info statement execution. Please check the error log for details.");
}

// Bind the result variables for travel_info with gender condition
$stmt_travel_gender->bind_result($avg_per_person_gender, $avg_per_day_gender);

if ($stmt_travel_gender->fetch()) {
} else {
    echo "No data found.";
}

$stmt_travel_gender->close();

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
    <link href="/static/css/cost-prediction.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <h1 style="text-align: center;">Travel Expense Visualization</h1>
    
    <h2 style="text-align: center;">Average With Activity</h2>
    <center-item>
        <div class="static-chart">
            <div id="expenseText" style="text-align: center; font-size: 20px;"></div>
        </div>
    </center-item>
    <script>
        // 데이터 가공
        var avgPerPersonData = <?php echo json_encode($avg_per_person); ?>;
        var avgPerDayData = <?php echo json_encode($avg_per_day); ?>;

        // 텍스트로 표시할 내용 생성
        var expenseText = `
            <p><strong>Expense Per Person:</strong> $${Number(avgPerPersonData).toFixed(2)}</p>
            <p><strong>Expense Per Day:</strong> $${Number(avgPerDayData).toFixed(2)}</p>
        `;

        // HTML에 적용
        document.getElementById('expenseText').innerHTML = expenseText;
    </script>

    <h2 style="text-align: center;">Average With Age</h2>
    <center-item>
        <div class="static-chart">
            <div id="expenseTextAge" style="text-align: center; font-size: 20px;"></div>
        </div>
    </center-item>
    <script>
        // 데이터 가공
        var avgPerPersonDataAge = <?php echo json_encode($avg_per_person_age); ?>;
        var avgPerDayDataAge = <?php echo json_encode($avg_per_day_age); ?>;

        // 텍스트로 표시할 내용 생성
        var expenseTextAge = `
            <p><strong>Expense Per Person (Age):</strong> $${Number(avgPerPersonDataAge).toFixed(2)}</p>
            <p><strong>Expense Per Day (Age):</strong> $${Number(avgPerDayDataAge).toFixed(2)}</p>
        `;

        // HTML에 적용
        document.getElementById('expenseTextAge').innerHTML = expenseTextAge;
    </script>

    <h2 style="text-align: center;">Average With Period</h2>
    <center-item>
        <div class="static-chart">
            <div id="expenseTextPeriod" style="text-align: center; font-size: 20px;"></div>
        </div>
    </center-item>
    <script>
        // 데이터 가공
        var avgPerPersonDataPeriod = <?php echo json_encode($avg_per_person_period); ?>;
        var avgPerDayDataPeriod = <?php echo json_encode($avg_per_day_period); ?>;

        // 텍스트로 표시할 내용 생성
        var expenseTextPeriod = `
            <p><strong>Expense Per Person (Period):</strong> $${Number(avgPerPersonDataPeriod).toFixed(2)}</p>
            <p><strong>Expense Per Day (Period):</strong> $${Number(avgPerDayDataPeriod).toFixed(2)}</p>
        `;

        // HTML에 적용
        document.getElementById('expenseTextPeriod').innerHTML = expenseTextPeriod;
    </script>

    <h2 style="text-align: center;">Average With Gender</h2>
    <center-item>
        <div class="static-chart">
            <div id="expenseTextGender" style="text-align: center; font-size: 20px;"></div>
        </div>
    </center-item>
    <script>
        // 데이터 가공
        var avgPerPersonDataGender = <?php echo json_encode($avg_per_person_gender); ?>;
        var avgPerDayDataGender = <?php echo json_encode($avg_per_day_gender); ?>;

        // 텍스트로 표시할 내용 생성
        var expenseTextGender = `
            <p><strong>Expense Per Person (Gender):</strong> $${Number(avgPerPersonDataGender).toFixed(2)}</p>
            <p><strong>Expense Per Day (Gender):</strong> $${Number(avgPerDayDataGender).toFixed(2)}</p>
        `;

        // HTML에 적용
        document.getElementById('expenseTextGender').innerHTML = expenseTextGender;
    </script>

</body>

</html>

