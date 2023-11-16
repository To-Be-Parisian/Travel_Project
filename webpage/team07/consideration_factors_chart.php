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

// 한국 방문 선택 시 고려요인 데이터 가져오기
$sql_reason_avg = "SELECT * FROM reason_amount_avg";
$result_reason_avg = $conn->query($sql_reason_avg);

// 데이터베이스 연결 종료
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consideration Factors for Visiting Korea</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="/static/css/text-style.css" rel="stylesheet" />
    <link rel="stylesheet" href="./static/css/home.css">
    <link href="/static/css/consideration.css" rel="stylesheet" />
</head>
<body>
<h1>To Be Parsian</h1>
<?php
        $currentPage = 'satisfaction'; // 현재 페이지 식별자
        include 'nav.php';
    ?>    
<h1>Consideration Factors for Visiting Korea</h1>
<center-item>
  <div class="statics-chart" >
    <canvas id="reasonAvgChart" width="400" height="400"></canvas>
  </div>
</center-item>


<script>
// 데이터 가공
var reasonAvgLabels = [];
var reasonAvgData = [];

<?php
while ($row = $result_reason_avg->fetch_assoc()) {
    echo "reasonAvgLabels.push('" . $row['factors_for_visiting_korea'] . "');";
    echo "reasonAvgData.push(" . $row['avg_expense_per_person'] . ");";
}
?>

// 파이 차트 생성
var reasonAvgCtx = document.getElementById('reasonAvgChart').getContext('2d');
var reasonAvgChart = new Chart(reasonAvgCtx, {
    type: 'pie',
    data: {
        labels: reasonAvgLabels,
        datasets: [{
            data: reasonAvgData,
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