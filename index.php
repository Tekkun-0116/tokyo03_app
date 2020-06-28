<?php

require_once('config.php');
require_once('functions.php');

session_start();

$dbh = connectDb();
$sql = 'SELECT * FROM lives ORDER BY updated_at ASC';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$lives = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tokyo03 Blog</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="flex-col-area">
    <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-5">
      <a href="http://localhost" class="navbar-brand">Tokyo03 Blog</a>
      <div class="collapse navbar-collapse" id="navbarToggle">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
          <?php if ($_SESSION['id']) : ?>
            <li class="nav-item">
              <a href="sign_out.php" class="nav-link">ログアウト</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a href="sign_in.php" class="nav-link">ログイン</a>
            </li>
            <li class="nav-item">
              <a href="sign_up.php" class="nav-link">アカウント登録</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-sm-20 col-md-20 col-lg-20 mx-auto">
          <div class="row">
            <?php foreach ($lives as $live) : ?>
              <div class="col-md-6">
                <div class="article">
                  <h3 class="live-title"><a href="show.php?id=<?php echo h($live['id']); ?>"><?php echo h($live['title']); ?></a></h3>
                  <p>公演日時:<?php echo h($live['live_date']); ?></p>
                  <p>ライブ内容:<?php echo h($live['content']); ?></p>
                  <p><?php echo h(mb_strimwidth($live['body'], 0, 63, "...")) ?></p>
                </div>
                <hr>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer font-small bg-info">
      <div class="footer-copyright text-center py-3 text-light">&copy; 2020 Tokyo03 Blog</div>
    </footer>
  </div>
</body>

</html>