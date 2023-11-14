<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="satisfaction-page.php" <?php echo ($currentPage == 'satisfaction') ? 'class="active"' : ''; ?>>Satisfaction Statistics</a></li>
        <li><a href="sex-age-statistics.php" <?php echo ($currentPage == 'sex-age-statistics') ? 'class="active"' : ''; ?>>Gender & Age Statistics</a></li>
        <li><a href="main-activity-chart.php" <?php echo ($currentPage == 'main-activity-chart') ? 'class="active"' : ''; ?>>Main Activity Statistics</a></li>
        <li><a href="consideration_factors_chart.php" <?php echo ($currentPage == 'consideration_factors_chart') ? 'class="active"' : ''; ?>>Consideration Factors Statistics</a></li>
        <li><a href="cost-statistics.php" <?php echo ($currentPage == 'cost-statistics') ? 'class="active"' : ''; ?>>Cost Statistics</a></li>
        <li><a href="visit-cnt-recommendation.php" <?php echo ($currentPage == 'visit-cnt-recommendation') ? 'class="active"' : ''; ?>>Number Of Visiting Statistics</a></li>
        <li><a href="country-recommendation.php" <?php echo ($currentPage == 'country-recommendations') ? 'class="active"' : ''; ?>>Country Statistics</a></li>
    </ul>
</nav>
