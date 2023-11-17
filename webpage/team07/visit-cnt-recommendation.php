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

// 방문 횟수별 국가 분포 데이터 조회
$sql = "SELECT visit_count, country_of_origin, cnt FROM from_count";
$result = $conn->query($sql);

// 데이터 배열 초기화
$visitCountData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $visitCountData[$row["visit_count"]][] = [
            'country' => $row["country_of_origin"],
            'cnt' => $row["cnt"]
        ];
    }
}

// 데이터베이스 연결 종료
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Visualization</title>
    <!-- Chart.js CDN 추가 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="./static/css/text-style.css" rel="stylesheet" />
    <link rel="stylesheet" href="./static/css/home.css">
    <link href="./static/css/visit-recom.css" rel="stylesheet" />
    
</head>
<body>
<h1>To Be Parsian</h1>
  <?php
        $currentPage = 'visit-cnt-recommendation'; // 현재 페이지 식별자
        include 'nav.php';
    ?>    
<h1>Country distribution by number of visits to Korea</h1>
<?php foreach ($visitCountData as $visitCount => $countries): ?>
    <h2><?php echo $visitCount; ?> Times Visited</h2>
    <center-item>
        <div class = "statics-chart">
            <canvas id="visitCountChart<?php echo $visitCount; ?>" width="400" height="200"></canvas>
        </div>
    </center-item>
    <script>
        var visitCountData<?php echo $visitCount; ?> = <?php echo json_encode($countries); ?>;

        var visitCountCtx<?php echo $visitCount; ?> = document.getElementById('visitCountChart<?php echo $visitCount; ?>').getContext('2d');
        var visitCountChart<?php echo $visitCount; ?> = new Chart(visitCountCtx<?php echo $visitCount; ?>, {
            type: 'bar',
            data: {
                labels: visitCountData<?php echo $visitCount; ?>.map(data => data.country),
                datasets: [{
                    label: 'Data Amount',
                    data: visitCountData<?php echo $visitCount; ?>.map(data => data.cnt),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
<?php endforeach; ?>
</body>
</html>