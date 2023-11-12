<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./static/css/likely.css" rel="stylesheet" />
  <title>Page-Likely</title>
</head>
<body>
  <h1>Travel Statistics Dashboard</h1>
  <div class = "chart-container">

    <!-- 추천의향에 따른 통계 -->
    <?php include './recommend-likely.php'; ?>

    <!-- 재방문의향에 따른 통계 -->
    <?php include './revisit-likely.php'; ?>
    <!-- 만족도에 따른 통계 -->
    <?php include './satisfaction.php'; ?>
  </divl>
</body>
</html>