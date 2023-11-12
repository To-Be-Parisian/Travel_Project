<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="satisfaction-page.php" <?php echo ($currentPage == 'satisfaction') ? 'class="active"' : ''; ?>>Satisfaction Statistics</a></li>
        <li><a href="sex-age-statistics.php" <?php echo ($currentPage == 'sex-age-statistics') ? 'class="active"' : ''; ?>>Gender & Age Statistics</a></li>
        <li><a href="main-activity-chart.php" <?php echo ($currentPage == 'main-activity-chart') ? 'class="active"' : ''; ?>>Main Activity Statistics</a></li>
    </ul>
</nav>
