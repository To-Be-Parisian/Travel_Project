<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "team07";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 외국인들의 주요 참여 활동 + 방문 위치 데이터 가져오기
$sql_travel_act = "SELECT * FROM travel_act_amount";
$result_travel_act = $conn->query($sql_travel_act);

// 데이터베이스 연결 종료
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Activities and Visit Locations</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="/static/css/text-style.css" rel="stylesheet" />
    <link rel="stylesheet" href="./static/css/home.css">
    <link href="/static/css/main-activity.css" rel="stylesheet" />
</head>
<body>
 <h1>To Be Parsian</h1>
<?php
        $currentPage = 'satisfaction'; // 현재 페이지 식별자
        include 'nav.php';
    ?>    
<h1>Main Activities and Visit Locations</h1>
<center-item>
    <div class="statics-chart">
    <canvas id="travelActChart"></canvas>
    </div>
</center-item>

<script>
// 데이터 가공
var travelActLabels = [];
var travelActData = [];

<?php
while ($row = $result_travel_act->fetch_assoc()) {
    echo "travelActLabels.push('" . $row['main_activity'] . "');";
    echo "travelActData.push(" . $row['avg_expense_per_person'] . ");";
}
?>

var travelActCtx = document.getElementById('travelActChart').getContext('2d');
var travelActChart = new Chart(travelActCtx, {
    type: 'pie',
    data: {
        labels: travelActLabels,
        datasets: [{
            data: travelActData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    }
});
</script>

</body>
</html>