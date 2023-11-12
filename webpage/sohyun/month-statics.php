<?php
$servername = "localhost";
$username = "root";
$password = "thgus201";
$dbname = "php";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$sql = "SELECT visit_duration, visit_month, SUM(cnt) as total_cnt FROM travel_period GROUP BY visit_duration, visit_month";

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
</head>
<body>
<canvas id="myChart"></canvas>
<script>
    // 데이터 가공
    var data = <?php echo json_encode($data); ?>;
    const ct = document.getElementById('myChart').getContext('2d');
    const chart = new Chart(ct, {
        type: 'bar',
        data: {
            labels: [...new Set(data.map(item => item.visit_month))], // 중복 제거
            datasets: data.reduce((datasets, item) => {
                let dataset = datasets.find(ds => ds.label === item.visit_duration);
                if (!dataset) {
                    dataset = {
                        label: item.visit_duration,
                        data: [],
                        backgroundColor: 'rgba(' + Math.floor(Math.random() * 255) + ', ' + Math.floor(Math.random() * 255) + ', ' + Math.floor(Math.random() * 255) + ', 0.5)'
                    };
                    datasets.push(dataset);
                }
                dataset.data.push(item.total_cnt); // total_cnt로 수정
                return datasets;
            }, [])
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: '월별 방문 기간별 방문자 수'
            },
            scales: {
              x: [{
            display: true,
            scaleLabel: {
                display: true,
                labelString: '방문 월'
            }
            }],
              y: [{
                  display: true,
                  scaleLabel: {
                      display: true,
                      labelString: '방문자 수'
                  }
              }]
            }
        }
    });
</script>
</body>
</html>
