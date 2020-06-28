<?php

require_once('config.php');
require_once('functions.php');

session_start();
$dbh = connectDb();


if ($_SESSION['id']) {
  header('Location: index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $errors = [];

  if ($email == '') {
    $errors[] = 'emailが未入力です';
  }

  if ($password == '') {
    $errors[] = 'passwordが未入力です';
  }

  if (empty($errors)) {

    $sql = 'SELECT * FROM user WHERE email = :email';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $user['password'])) {
      $_SESSION['id'] = $user['id'];
      $url = $_SERVER['HTTP_REFERER'];
      header('Location: ' . $url);
      exit;
    } else {
      $errors[] = 'メールアドレスかパスワードが間違っています';
    }
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
            <li class="nav-item">
              <a href="new.php" class="nav-link">New Post</a>
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
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card my-5">
            <div class="card-body">
              <h3 class="card-title text-center alert alert-info text-dark">ログイン</h3>
              <?php if ($errors) : ?>
                <ul class="alert alert-danger">
                  <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <form class="" action="sign_in.php" method="post">
                <div class="form-group">
                  <label for="email">メールアドレス</label>
                  <input type="email" class="form-control" required autofocus name="email">
                </div>
                <div class="form-group">
                  <label for="password">パスワード</label>
                  <input type="password" class="form-control" required name="password">
                </div>
                <div class="form-group">
                  <input type="submit" value="ログイン" class="btn btn-lg btn-primary btn-block ">
                </div>
                <a href="sign_up.php" class="btn btn-lg btn-success btn-block mt-2">アカウント登録</a>
              </form>
            </div>
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