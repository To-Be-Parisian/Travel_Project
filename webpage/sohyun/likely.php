<?php
// 여행 만족도, 추천 의향, 재방문 의향에 대한 통계를 계산하는 함수
function calculateStatistics() {
    // 여기에 필요한 데이터베이스 연결 및 쿼리 수행 코드를 추가하세요.
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
    // 여행 만족도 통계
    $satisfactionQuery = "SELECT satisfaction_avg, count
                          FROM travel_like";
    // 추천 의향 통계
    $recommendationQuery = "SELECT visit_location, recommendation_intent_avg AS avg_recommendation
                            FROM travel_like_avg_location";
    // 재방문 의향 통계
    $revisitQuery = "SELECT main_activity, revisit_intent_avg
                     FROM travel_revisit";

    $satisfactionResult = $conn->query($satisfactionQuery);

    if ($satisfactionResult->num_rows > 0) {
        while ($row = $satisfactionResult->fetch_assoc()) {
            $avgSatisfaction = $row["satisfaction_avg"];
            $recordCount = $row["count"];
        }
    } else {
        $avgSatisfaction = 0;
        $recordCount = 0;
    }
    $recommendationResult = $conn->query($recommendationQuery);

    $avgRecommendation = array();
    if ($recommendationResult->num_rows > 0) {
        while ($row = $recommendationResult->fetch_assoc()) {
            $avgRecommendation[$row["visit_location"]] = $row["avg_recommendation"];
        }
    }
        
    $revisitResult = $conn->query($revisitQuery);

    $avgRevisit = array();
    if ($revisitResult->num_rows > 0) {
        while ($row = $revisitResult->fetch_assoc()) {
          $avgRevisit[$row["main_activity"]] = $row["revisit_intent_avg"];
    }
}

// 데이터베이스 연결 해제
$conn->close();
return array($avgSatisfaction, $recordCount, $avgRecommendation, $avgRevisit);
}

// 통계를 얻어오기
list($avgSatisfaction, $recordCount, $avgRecommendation, $avgRevisit) = calculateStatistics();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Statistics</title>
</head>
<body>
    <h1>Travel Statistics</h1>

    <h2>여행 만족도 통계</h2>
    <p>평균 만족도: <?php echo $avgSatisfaction; ?></p>
    <p>총 레코드 수: <?php echo $recordCount; ?></p>

    <h2>추천 의향 통계</h2>
    <ul>
        <?php foreach ($avgRecommendation as $location => $avg) : ?>
            <li><?php echo "{$location}: {$avg}"; ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>재방문 의향 통계</h2>
    <ul>
        <?php foreach ($avgRevisit as $activity => $avg) : ?>
            <li><?php echo "{$activity}: {$avg}"; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
