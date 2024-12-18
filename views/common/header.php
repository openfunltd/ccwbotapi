<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>公督盟國會追蹤機器人</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.css">
<title><?= $this->escape($this->app_name) ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">公督盟國會追蹤機器人</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/">首頁</a>
        </li>
        <?php if ($this->user) { ?>
            <li class="nav-item">
                <a class="nav-link" href="/user/follow">我的追蹤</a>
            </li>
            <li class="nav-item">
                <span class="nav-link">Hi! <?= $this->escape($this->user->name) ?>
                    (<a href="/user/logout">登出</a>)
                </span>
            </li>
            <?php if ($this->user->is_admin) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="/admin">管理介面</a>
                </li>
            <?php } ?>
        <?php } else { ?>
            <li>
                <a class="nav-link" href="/user/googlelogin">Google登入</a>
            </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
