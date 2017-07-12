<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="favicon.ico" >
    <link rel="Shortcut Icon" href="favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?=asset('static/h-ui/css/H-ui.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?=asset('static/h-ui.admin/css/H-ui.admin.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?=asset('lib/Hui-iconfont/1.0.8/iconfont.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?=asset('static/h-ui.admin/skin/default/skin.css') ?>" id="skin" />
    <link rel="stylesheet" type="text/css" href="<?=asset('static/h-ui.admin/css/style.css') ?>" />
    <title>皇老鸭</title>
</head>
<body>

<!-- 头部 -->
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl">
            <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/">皇老鸭</a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs">v0.1</span>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A">{{Auth::guard()->user()->username}} <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="/logout">退出</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- 菜单 -->
<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <dl id="menu-order">
            <dt @if ($menu == "order") class="selected" @endif>
                <i class="Hui-iconfont">&#xe616;</i> 订单管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "order") style="display: block;" @endif>
                <ul>
                    <li @if ($page == "order.list") class="current" @endif>
                        <a href="/" title="订单列表">订单列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-ads">
            <dt @if ($menu == "ads") class="selected" @endif>
                <i class="Hui-iconfont">&#xe613;</i> 宣传管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "ads") style="display: block;" @endif>
                <ul>
                    <li @if ($page == "ads.list") class="current" @endif>
                        <a href="picture-list.html" title="宣传列表">宣传列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-product">
            <dt @if ($menu == "product") class="selected" @endif>
                <i class="Hui-iconfont">&#xe620;</i> 产品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "product")  style="display: block;" @endif>
                <ul>
                    <li @if ($page == "product.category") class="current" @endif>
                        <a href="product-category.php" title="分类管理">分类管理</a>
                    </li>
                    <li @if ($page == "product.list") class="current" @endif>
                        <a href="product-list.php" title="产品列表">产品列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">
            <dt @if ($menu == "admin") class="selected" @endif>
                <i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "admin")  style="display: block;" @endif>
                <ul>
                    {{--<li @if ($page == "admin.role") class="current" @endif>--}}
                        {{--<a href="admin-role.php" title="角色管理">角色管理</a>--}}
                    {{--</li>--}}
                    <li @if ($page == "admin.list") class="current" @endif>
                        <a href="admin-list.php" title="管理员列表">管理员列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-tongji">
            <dt @if ($menu == "stat") class="selected" @endif>
                <i class="Hui-iconfont">&#xe61a;</i> 数据统计<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "stat")  style="display: block;" @endif>
                <ul>
                    <li @if ($page == "stat.data") class="current" @endif>
                        <a href="charts-1.html" title="自定义查询">自定义查询</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-system">
            <dt @if ($menu == "system") class="selected" @endif>
                <i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "system")  style="display: block;" @endif>
                <ul>
                    <li @if ($page == "system.setting") class="current" @endif>
                        <a href="system-base.html" title="系统设置">系统设置</a>
                    </li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>

@yield('content')

<!--_footer -->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.page.js"></script>

@yield('script')

</body>
</html>