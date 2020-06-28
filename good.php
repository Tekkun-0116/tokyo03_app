<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // フォームに入力されたデータの受け取り
  $id = $_GET['id'];
  $good = $_GET['good'];

  if ($good == "1") {
    $good_value = 1;
  } else {
    $good_value = 0;
  }

  // データを更新する処理
  $sql = "update good set good = :good where id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->bindParam(":good", $good);
  $stmt->execute();
  $tweet = $stmt->fetch(PDO::FETCH_ASSOC);


  $hpr = $_SERVER['HTTP_REFERER'];
  header('Location:' . $hpr);
  exit;
}
