<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "thgus201";
$dbname = "php";

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
    <link href="/static/css/text-style.css" rel="stylesheet" />
    <link href="/static/css/visit-recom.css" rel="stylesheet" />
</head>
<body>

<div class="statics-chart">
<?php foreach ($visitCountData as $visitCount => $countries): ?>
    <h2><?php echo $visitCount; ?> times Visited</h2>
    <canvas id="visitCountChart<?php echo $visitCount; ?>"></canvas>

    <script>
        // <?php echo $visitCount; ?>회 방문 국가 분포 데이터
        var visitCountData<?php echo $visitCount; ?> = <?php echo json_encode($countries); ?>;

        // <?php echo $visitCount; ?>회 방문 국가 분포 그래프 생성
        var visitCountCtx<?php echo $visitCount; ?> = document.getElementById('visitCountChart<?php echo $visitCount; ?>').getContext('2d');
        var visitCountChart<?php echo $visitCount; ?> = new Chart(visitCountCtx<?php echo $visitCount; ?>, {
            type: 'bar',
            data: {
                labels: visitCountData<?php echo $visitCount; ?>.map(data => data.country),
                datasets: [{
                    label: '데이터 개수',
                    data: visitCountData<?php echo $visitCount; ?>.map(data => data.cnt),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
<?php endforeach; ?>
</div>

</body>
</html>