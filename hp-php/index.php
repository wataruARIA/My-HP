<?php

$dataFile = 'comments.php';


session_start();

function setToken() {
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
}

function checkToken() {
    if (empty($_SESSION['token']) || $_SESSION['token'] != $_POST['token']) {
      echo "不正なPOSTをが行われました";
      exit;
    }
}


function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}


function redirect() {
  header('Location: http://' .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['message']) &&
    isset($_POST['user'])) {

      checkToken(); 

    $message = trim($_POST['message']);
    $user = trim($_POST['user']);

    if ($message !== '') {

        $user = ($user === '') ? 'ななしさん' : $user;

        $message = str_replace("\t", ' ', $message);
        $user = str_replace("\t", ' ', $user);

        $postedAt = date('Y-m-d H:i:s');

        $newData = $message . "\t" . $user . "\t" . $postedAt . "\n";

        $fp = fopen($dataFile, 'a');
        fwrite($fp, $newData);
        fclose($fp);
    }
    redirect();
} else {
    setToken(); 
  }

$posts = file($dataFile, FILE_IGNORE_NEW_LINES);

$posts = array_reverse($posts);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Wataru</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.8/font-awesome-animation.min.css' type='text/css' media='all' />
  </head>
  <body>
  <meta name="viewport" content="target-densitydpi=device-dpi, width=1200px, maximum-scale=1.0, user-scalable=yes">
    <div class="header">
      <div class="container">
        <div class="header-left">
          <div class="logo">Wataru</div>
        </div>
        <div class="header-right">
          <a href="https://twitter.com/ezweb_cola"><i class="fab fa-twitter faa-wrench animated "></i>公式Twitterはこちら</a>
        </div>
      </div>
    </div >
<div class="main">
 <div class="introduce">
  <div class="container">
    <h1>webエンジニアを目指して</h1>
    <h1>はじめまして！</h1>
    <p>Wataruと申します </p>
    <P>Wataru は日々進化を追い求め精進して参ります</p>
    <p>星空が大好きです<p>
  </div>
 </div>
 <div class="study">
    <div class="container">
      <div class="heading">
        <h2>現在学習中の言語</h2>
      </div>
      <div class="lessons">
        <div class="lesson">
          <img src="html.jpg" width=120px height=65px>
          <h2>HTML & CSS</h2>
        </div>
        <div class="lesson">
          <img src="ruby.jpg" width=120px height=65px>
            <h2 class="selected">Ruby</h2>
        </div>
        <div class="lesson">
          <img src="java.jpg" width=120px height=65px >
          <h2>java<h2>
       </div>
       <div class="lesson">
         <img src="php.jpg" width=120px height=65px>
         <h2>PHP</h2>
       </div>
    </div>
    <div class="ending">
     <div class="container">
      <h2>エンジニアのお友達が欲しいです涙</h2>
      <p>やる気あります<span>!!</span></p>
      <p>なので良かったら仲良くしてくらさい、、。</p>
      <p>Twitterのフォロー、お待ちしております('ω')ノ</p>
     </div>
    </div>
 </div>
</div>
<div class="comment-form">
<h1>コメント欄</h1>
        <form action="" method="post">
            message:<input type="text" name="message" >
            user:<input type="text" name="user" >
            <input type="submit" value="投稿" >
            <input type="hidden" name="token" value="<?php echo ($_SESSION['token']); ?>" >
        </form>
        <h2>投稿一覧（<?php echo count($posts); ?>件）</h2>
        <ul>
            <?php if(count($posts)) : ?>
                <?php foreach ($posts as $post) : ?>
                <?php list($message, $user, $postedAt) = explode("\t", $post); ?>
                    <li><?php echo h($message); ?>　<?php echo h($user); ?>　<?php echo h($postedAt); ?> </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>まだ投稿はありません。</li>
            <?php endif; ?>
        </ul>
</div>
<div class="footer">
  <div class="container">
    <div class="footer-left">
      <h3>Wataru</h3>
    </div>
    <div class="footer-right">
      <ul>
        <li>TEL:080-6495-5353</li>
        <li>Mail:wataru.altair@icloud.com</li>
        <li>〒136-0076</li>
        <li>東京都江東区南砂7-13-17</li>
      </ul>
    </div>
  </div>
</div>
  </body>
</html>