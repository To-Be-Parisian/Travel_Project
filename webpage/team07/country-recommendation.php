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

function getContinent($country) {
    $continentMapping = [
        'Others' => 'Others',
        'Taiwan' => 'Asia',
        'Germany' => 'Europe',
        'Russia' => 'Europe',
        'Malaysia' => 'Asia',
        'Mongolia' => 'Asia',
        'USA' => 'North_America',
        'Vietnam' => 'Asia',
        'Singapore' => 'Asia',
        'United Kingdom' => 'Europe',
        'India' => 'Asia',
        'Indonesia' => 'Asia',
        'Japan' => 'Asia',
        'China' => 'Asia',
        'Middle East' => 'Middle East',
        'Canada' => 'North_America',
        'Thailand' => 'Asia',
        'France' => 'Europe',
        'Philippines' => 'Asia',
        'Australia' => 'Oceania',
        'Hong Kong' => 'Asia',
    ];

    return isset($continentMapping[$country]) ? $continentMapping[$country] : 'Others';
}

// 출신 국가별 입출국 공항 비율 데이터 조회
$sql = "SELECT country_of_origin, entry_exit_airport, cnt FROM from_airport";
$result = $conn->query($sql);

// 데이터 배열 초기화
$airportData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $airportData[$row["country_of_origin"]][] = [
            'entry_exit_airport' => $row["entry_exit_airport"],
            'cnt' => $row["cnt"]
        ];
    }
}

// 출신 국가별 만족도 및 추천 의향 데이터 조회
$sql = "SELECT country_of_origin, satisfaction_avg, recommendation_intent_avg, cnt FROM travel_from_avg";
$result = $conn->query($sql);

// 데이터 배열 초기화
$travelFromData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $travelFromData[] = [
            'country' => $row["country_of_origin"],
            'satisfaction_avg' => $row["satisfaction_avg"],
            'recommendation_intent_avg' => $row["recommendation_intent_avg"],
            'cnt' => $row["cnt"]
        ];
    }
}

// Modify your PHP loop to group data by continent
$continentData = [];
foreach ($airportData as $country => $airports) {
    if ($country === 'Hong Kong' || $country === 'Middle East') continue;
    $continent = getContinent($country); // Define a function to get the continent for a given country
    $continentData[$continent][$country] = $airports;
}

$continentStats = [];

foreach ($continentData as $continent => $countries) {
    $airportStats = [];

    // 도표 데이터를 집계
    foreach ($countries as $country => $airports) {
        foreach ($airports as $data) {
            if (!isset($airportStats[$data['entry_exit_airport']])) {
                $airportStats[$data['entry_exit_airport']] = 0;
            }
            $airportStats[$data['entry_exit_airport']] += $data['cnt'];
        }
    }
    echo(json_encode($continent));
    // 대륙별 도표 생성
    $continentStats[$continent] = [
        'labels' => array_keys($airportStats),
        'data' => array_values($airportStats),
    ];
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
    <link rel="stylesheet" href="./static/css/home.css">
    <link href="./static/css/visit-recom.css" rel="stylesheet" />
    <link href="./static/css/text-style.css" rel="stylesheet" />
</head>
<body>
<h1>To Be Parsian</h1>
<?php
$currentPage = 'country-recommendations';
include 'nav.php';
?>    
<h1>Statistics Based On Country & Continent - Drill Down</h1>

<?php foreach ($continentStats as $continent => $stats): ?>
    <h2>Distribution of arrival airports in <?php echo $continent; ?></h2>
    <center-item>
        <div class="statics-chart-margin">
            <canvas id="continentChart<?php echo $continent; ?>" width="400" height="200"></canvas>
        </div>
    </center-item>
    <script>
        var continentData<?php echo $continent; ?> = <?php echo json_encode($stats); ?>;
        var continentCtx<?php echo $continent; ?> = document.getElementById('continentChart<?php echo $continent; ?>').getContext('2d');
        var continentChart<?php echo $continent; ?> = new Chart(continentCtx<?php echo $continent; ?>, {
            type: 'doughnut',
            data: {
                labels: continentData<?php echo $continent; ?>.labels,
                datasets: [{
                    data: continentData<?php echo $continent; ?>.data,
                    backgroundColor: [
                        'rgba(120, 210, 132, 0.8)',
                        'rgba(134, 70, 120, 0.8)',
                    ],
                }]
            }
        });
    </script>
    
    <?php foreach ($continentData[$continent] as $country => $airports): ?>
        <?php if ($country === 'Hong Kong' || $country === 'Middle East') continue; ?>
        <center-item>
            <h3>Distribution of arrival airports by country: <?php echo $country; ?></h3>
            <div class="statics-chart-margin">
                <canvas id="airportChart<?php echo $country; ?>" width="400" height="200"></canvas>
            </div>
        </center-item>
        <script>
            var airportData<?php echo $country; ?> = <?php echo json_encode($airports); ?>;
            var airportCtx<?php echo $country; ?> = document.getElementById('airportChart<?php echo $country; ?>').getContext('2d');
            var airportChart<?php echo $country; ?> = new Chart(airportCtx<?php echo $country; ?>, {
                type: 'doughnut',
                data: {
                    labels: airportData<?php echo $country; ?>.map(data => data.entry_exit_airport),
                    datasets: [{
                        data: airportData<?php echo $country; ?>.map(data => data.cnt),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                        ],
                    }]
                }
            });
        </script>
    <?php endforeach; ?>
<?php endforeach; ?>

<h2>Satisfaction and recommendation intention by country of origin</h2>
<center-item>
    <div class="statics-chart">
        <canvas id="travelFromChart" width="400" height="200"></canvas>
    </div>
</center-item>
<script>
    var travelFromData = <?php echo json_encode($travelFromData); ?>;
    var travelFromCtx = document.getElementById('travelFromChart').getContext('2d');
    var travelFromChart = new Chart(travelFromCtx, {
        type: 'bar',
        data: {
            labels: travelFromData.map(data => data.country),
            datasets: [{
                label: 'Average Of Satisfaction',
                data: travelFromData.map(data => data.satisfaction_avg),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Average Of Recommendation',
                data: travelFromData.map(data => data.recommendation_intent_avg),
                backgroundColor: 'rgba(255, 99, 132,  0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        }
    });
</script>
</body>
</html>