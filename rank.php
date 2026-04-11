<?php
@require 'conn.php';
@session_start();
$accept_language = '';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
  $accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
}
$language_rules = array(
  array('regex' => '/^zh-TW\b/i', 'lang' => 'zht'),
  array('regex' => '/^zh-HK\b/i', 'lang' => 'zht'),
  array('regex' => '/^zh-MO\b/i', 'lang' => 'zht'),
  array('regex' => '/^zh-Hans\b/i', 'lang' => 'zh'),
  array('regex' => '/^zh-Hant\b/i', 'lang' => 'zht'),
  array('regex' => '/^zh\b/i', 'lang' => 'zh'),
  array('regex' => '/^ja\b/i', 'lang' => 'ja'),
  array('regex' => '/.*/', 'lang' => 'en')
);
$lang_code = 'en';
if (!empty($accept_language)) {
  $langs = explode(',', $accept_language);
  $primary_lang = trim($langs[0]);
  $primary_lang = preg_replace('/;q=[0-9.]+$/', '', $primary_lang);
    
  foreach ($language_rules as $rule) {
    if (preg_match($rule['regex'], $primary_lang)) {
      $lang_code = $rule['lang'];
      break;
    }
  }
}
$lang_file = "static/i18n/" . $lang_code . ".json";
if (!file_exists($lang_file)) {
  $lang_file = "static/i18n/en.json";
}
$lang_data = file_get_contents($lang_file);
if ($lang_data === FALSE) {
  $lang_data = '{}';
}
$i18n = json_decode($lang_data, true);
if ($i18n === NULL) {
  $i18n = array();
}
//Maximum number of pages that can be displayed
$max_pages = 9;
$RankingType = isset($_GET['type']) ? $_GET['type'] : 'day';
//Number of items that can be displayed on each page
$num = 10;
$CurrentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
if (isset($_GET['name'])) {
  $_SESSION['name'] = $_GET['name'];
}
$offset = ($CurrentPage - 1) * $num;
if ($RankingType == 'query') {
  $queryname = isset($_GET['query']) ? $_GET['query'] : '';
  $title = $i18n['query-record'];
  $cond1 = "WHERE `name` LIKE ?";
  $cond2 = $cond1 . ";";
}
if ($RankingType == 'day') {
  $title = $i18n['day-rank'];
  $cond1 = "WHERE to_days(time) = to_days(now())";
  $cond2 = $cond1 . " ORDER BY `score` DESC limit ?,?;";
}
if ($RankingType == 'week') {
  $title = $i18n['week-rank'];
  $cond1 = "WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(time)";
  $cond2 = $cond1 . " ORDER BY `score` DESC limit ?,?;";
}
if ($RankingType == 'month') {
  $title = $i18n['month-rank'];
  $cond1 = "WHERE DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(time)";
  $cond2 = $cond1 . " ORDER BY `score` DESC limit ?,?;";
}
if ($RankingType == 'all') {
  $title = $i18n['all-rank'];
  $cond1 = "";
  $cond2 = "ORDER BY score DESC limit ?,?;";
}
?>
<!DOCTYPE html>
<html>

<head>
  <title data-i18n="rank-title">EatKun Ranking</title>
  <meta item="description" content="EatKun" />
  <meta charset="utf-8" />
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
  <link rel="icon" href="./static/image/ProgressiveWebApps.png" type="image/x-icon" />
  <link rel="apple-touch-icon" id="applogo" href="./static/image/ProgressiveWebApps.png">
  <link href="./static/css/LanguageDetection.css" rel="stylesheet" type="text/css">
  <link href="./files/css/bootstrap.min.css" rel="stylesheet">
  <script src="./files/js/bootstrap.bundle.min.js"></script>
  <script src="./files/js/jquery.min.js"></script>
</head>

<body onLoad="init()" oncontextmenu=self.event.returnValue=false>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="./" data-i18n="navbar-brand">NAVBER-BRAND-I18N</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?php echo $RankingType == 'day' ? "active" : ""; ?>" href="?type=day" data-i18n="daily-ranking">DAILY-RANKING-I18N</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $RankingType == 'week' ? "active" : ""; ?>" href="?type=week" data-i18n="weekly-ranking">WEEKLY-RANKING-I18N</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $RankingType == 'month' ? "active" : ""; ?>" href="?type=month" data-i18n="monthly-ranking">MOUTHLY-RANKING-I18N</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $RankingType == 'all' ? "active" : ""; ?>" href="?type=all" data-i18n="all-ranking">ALL-RANKING-I18N</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="javascript: void(0);" onclick="openWebpage('https://github.com/OneSitos/EatKun/')" data-i18n="source-code">SOURCE-CODE-I18N</a>
          </li>
        </ul>
        <form class="d-flex text-nowrap" action="" onsubmit="return false;">
          <input class="form-control me-2" id="search" placeholder="QUERY-INPUT-I18N" data-placeholder-i18n="query-input">
          <button class="btn btn-outline-success" onclick="local()" data-i18n="search-btn">SEARCH-BTN-I18N</button>
        </form>
      </div>
    </div>
  </nav>
  <div style="max-width:640px;margin:0 auto;">
    <div class="page-header text-center">
      <br />
      <h1 class="default-mouse" data-i18n="rank">RANK-I18N</h1><br />
    </div>
    <div class="list-group">
      <?php
      $rank = $offset;
      $data_sql = "SELECT * FROM " . $ranking . " " . $cond2;
      if ($data_stmt = $link->prepare($data_sql)) {
        if ($RankingType == "query") {
          $queryname = '%'.$queryname.'%';
          $data_stmt->bind_param("s", $queryname);
        } else {
          $data_stmt->bind_param("ii", $offset, $num);
        }
        $data_stmt->execute();
        $data_stmt->store_result();
        $data_stmt->bind_result($id, $score, $name, $time, $system, $area, $message, $attempts);
        if ($data_stmt->num_rows > 0) {
          while ($data_stmt->fetch()) {
            $rank += 1;
            $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            $safeMessage = htmlspecialchars($message ? $message : $i18n['no-message'], ENT_QUOTES, 'UTF-8');
            $safeSystem = htmlspecialchars($system, ENT_QUOTES, 'UTF-8');
            $safeArea = htmlspecialchars($area, ENT_QUOTES, 'UTF-8');
            $safeScore = htmlspecialchars($score, ENT_QUOTES, 'UTF-8');
            $safeAttempts = htmlspecialchars($attempts, ENT_QUOTES, 'UTF-8');
            $safeTime = htmlspecialchars($time, ENT_QUOTES, 'UTF-8');
            echo "<a href='#' class='list-group-item list-group-item-action'><div class='d-flex w-100 justify-content-between'>
            <h5 class='mb-1'>" . (($rank == 1 || $rank % 10 == 1) ? ($rank . "st ") : (($rank == 2 || $rank % 10 == 2) ? ($rank . "rd ") : ($rank . "th "))) . $safeName . "</h5><small>" . $safeTime . "</small></div>
            <p class='mb-1'>SCORE: " . $safeScore . " TRY: " . $safeAttempts . " -" . $safeSystem . " -" . $safeArea . "</p>
            <small>" . ($safeMessage ? $safeMessage : $i18n['no-message']) . "</small></a>";
          }
        } else {
          echo "<br/><br/><p class='text-center default-mouse' data-i18n='no-data'>NO-DATA-I18N</p>";
        }
        $data_stmt->close();
      }
      ?>
      <nav aria-label="Page navigation example" style="margin-bottom:3em;">
        <ul class="pagination">
          <?php
          if ($RankingType != "query") {
          $rows_sql = "SELECT count(*) FROM " . $ranking . " " . $cond1 . ";";
          if ($count_stmt = $link->prepare($rows_sql)) {
            $count_stmt->execute();
            $count_stmt->bind_result($rows);
            $count_stmt->fetch();
            $count_stmt->close();
          } else {
            $rows = 0;
          }
            $rows = $rows > $num * $max_pages ? $num * $max_pages : $rows;
            $total = ceil($rows / $num);
            if ($total > 1) {
              if ($CurrentPage > 1) {
                echo "<li class='page-item'><a class='page-link' href='?type=" . $RankingType . "&page=" . ($CurrentPage - 1) . "' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
              }
              for ($p = 1; $p <= $total; $p++) {
                echo "<li class='page-item " . ($CurrentPage == $p ? "active" : "") . "'><a class='page-link' href='?type=" . $RankingType . "&page=" . $p . "'>" . $p . "</a></li>";
              }
              if ($total > $CurrentPage) {
                echo "<li class='page-item'><a class='page-link' href='?type=" . $RankingType . "&page=" . ($CurrentPage + 1) . "' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
              }
            }
          }
          ?>
        </ul>
      </nav>
    </div>
    <footer class='fixed-bottom container' style='max-width:640px;'>
      <div class='row shadow rounded bg-light'>
        <div class="default-mouse" style='padding:0.2em 1em;'>
          <?php
          if (isset($_SESSION['name'])) {
            $safeName = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8');
            //Query current user history
            $score_sql = "SELECT `score`,`time`,`attempts` FROM " . $ranking . " where name=?";
            $score_stmt = $link->prepare($score_sql);
            $score_stmt->bind_param("s", $_SESSION['name']);
            $score_stmt->bind_result($score, $time, $attempts);
            $score_stmt->execute();
            if ($score_stmt->fetch()) {
              $safeScore = htmlspecialchars($score, ENT_QUOTES, 'UTF-8');
              $safeTime = htmlspecialchars($time, ENT_QUOTES, 'UTF-8');
              $safeAttempts = htmlspecialchars($attempts, ENT_QUOTES, 'UTF-8');
              echo strtr($i18n["self-record"], array("{name}" => $safeName, "{attempts}" => $safeAttempts, "{score}" => $safeScore, "{time}" => $safeTime));
            } else {
              echo strtr($i18n["no-self-record"], array("{name}" => $safeName));
            }
            $score_stmt->close();
          } else {
            echo $i18n["no-name-tip"];
          }
          $link->close();
          ?>
        </div>
      </div>
    </footer>
  </div>
<script src="./static/javascript/LanguageDetection.js"></script>
</body>

</html>