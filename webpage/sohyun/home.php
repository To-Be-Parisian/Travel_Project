<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="./static/css/text-style.css" rel="stylesheet" />
    <link rel="stylesheet" href="./static/css/home.css">
</head>
<body>

    <!-- 제목 -->
    <h1>To Be Parsian</h1>
    <!-- 네비게이션 바 -->
    <?php
        $currentPage = 'home'; // 현재 페이지 식별자
        include 'nav.php';
    ?>
    <?php include './cost-prediction.php'; ?>
</body>
</html>