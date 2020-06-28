<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql = "select * from comments order by created_at desc";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $comment = $_POST['comment'];
  $errors = [];

  if ($comment == '') {
    $errors['comment'] = 'コメントを入力してください。';
  }

  if (empty($errors)) {
    $sql = "insert into comments (comment, created_at) values (:comment, now())";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":comment", $comment);
    $stmt->execute();

    header('Location: comment.php');
    exit;
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

    <body>
      <div class="container">
        <di class="row">
          <div class="col-md-11 col-lg-9 mx-auto mt-5">
            <h1>コメント</h1>
            <br>
            <?php if (count($comments)) : ?>
              <ul class="comment-list">
                <?php foreach ($comments as $comment) : ?>
                  <li>
                    <a href="show.php?id=<?php echo h($comment['id']) ?>"><?php echo h($comment['comment']); ?></a><br>
                    投稿日時: <?php echo h($comment['created_at']); ?>
                    <?php if ($comment['good'] == false) : ?>
                      <a href="good.php?id=<?php echo h($comment['id']) . "&good=1"; ?>" class="good-link"><?php echo '♡'; ?></a>
                    <?php else : ?>
                      <a href="good.php?id=<?php echo h($comment['id']) . "&good=0"; ?>" class="bad-link"><?php echo '♥'; ?></a>
                    <?php endif; ?>
                    <hr>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else : ?>
              <p>投稿されたコメントはありません</p>
            <?php endif; ?>
            <div class="container">
              <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                  <?php if ($errors) : ?>
                    <ul class="error-list">
                      <li>
                        <?php echo h($errors['comment']); ?>
                      </li>
                    </ul>
                  <?php endif; ?>
                  <form action="" method="post">
                    <p>
                      <label for="comment"></label><br>
                      <textarea name="comment" cols="50" rows="7" placeholder="コメントを書いてください！"></textarea>
                      <br>
                      <input type="submit" value="投稿する"><br><br>
                      <a href="show.php?id=<?php echo h($comment['id']) ?>" class="btn btn-info">戻る</a>
                    </p>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
  <footer class="footer font-small bg-info">
    <div class="footer-copyright text-center py-3 text-light">&copy; 2020 Tokyo03 Blog</div>
  </footer>
</body>

</html>