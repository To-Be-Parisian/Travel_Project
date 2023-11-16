<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./static/css/likely.css" rel="stylesheet" />
    <link rel="stylesheet" href="./static/css/home.css">
  <title>Cost</title>
</head>
<body>
  <h1>To Be Parsian</h1>
  <?php
        $currentPage = 'satisfaction'; // 현재 페이지 식별자
        include 'nav.php';
    ?>    
  <h1>Cost Statistics Dashboard</h1>
  <div class = "chart-container">
    <?php include './term-cost.php'; ?>
    <?php include './month-statics.php'; ?>

  </div>
</body>
</html>