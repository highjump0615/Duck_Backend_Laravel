<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>mini shop</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=asset('css/login.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="login-page">
        <div class="text-center">
            <h3 style="color: white;"><strong>皇老鸭</strong></h3>
        </div>
        <div class="form">
            <form action="{{url('/login')}}" method="POST">
                {{ csrf_field() }}
                <input type="text" placeholder="用户名" name="username">
                <input type="password" placeholder="密码" name="password">
                <button type="submit">登录</button>
                <p class="message">忘了密码？ <a href="{{url('/login/forgot')}}">找回密码</a></p>
            </form>
        </div>
    </div>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap Javascript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom Javascript -->
    <script src="<?=asset('js/login.js') ?>"></script>
</body>
</html>