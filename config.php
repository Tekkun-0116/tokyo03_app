<?php

// 接続に必要な情報を定数として定義
define('DSN', 'mysql:host=db;dbname=tokyo03_blog;charset=utf8');
define('USER', 'admin');
define('PASSWORD', '2003');

// Noticeというエラーを非表示にする
error_reporting(E_ALL & ~E_NOTICE);