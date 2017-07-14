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
                        <a href="{{url('/')}}" title="订单列表">订单列表</a>
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
                        <a href="{{url('/ads')}}" title="宣传列表">宣传列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-product">
            <dt @if ($menu == "product") class="selected" @endif>
                <i class="Hui-iconfont">&#xe620;</i> 商品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "product")  style="display: block;" @endif>
                <ul>
                    <li @if ($page == "product.category") class="current" @endif>
                        <a href="{{url('/category')}}" title="分类管理">分类管理</a>
                    </li>
                    <li @if ($page == "product.list") class="current" @endif>
                        <a href="{{'/products'}}" title="产品列表">产品列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">
            <dt @if ($menu == "user") class="selected" @endif>
                <i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "user")  style="display: block;" @endif>
                <ul>
                    <li @if ($page == "user.list") class="current" @endif>
                        <a href="{{url('/user')}}" title="管理员列表">管理员列表</a>
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
                        <a href="{{url('/stat')}}" title="自定义查询">自定义查询</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-store">
            <dt @if ($menu == "store") class="selected" @endif>
                <i class="Hui-iconfont">&#xe66a;</i> 门店管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
            </dt>
            <dd @if ($menu == "store")  style="display: block;" @endif>
                <ul>
                    <li @if ($page == "store.list") class="current" @endif>
                        <a href="{{url('/store')}}" title="门店列表">门店列表</a>
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
                        <a href="{{url('/setting')}}" title="系统设置">系统设置</a>
                    </li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
