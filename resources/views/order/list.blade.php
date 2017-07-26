@extends('layout.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="<?=asset('css/pagination.css') ?>" />
@endsection

@section('content')

    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 订单列表
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
        <div class="Hui-article">

            <form action="{{url('/')}}" method="get">
                <div class="filter-nav text-c">
                    <div class="fields-div">
                        <div>
                            <!-- 日期范围 -->
                            日期范围：
                            <input type="text"
                                   onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})"
                                   id="logmin"
                                   class="input-text Wdate"
                                   name="start_date"
                                   @if (!empty($start_date)) value="{{$start_date}}" @endif>
                            -
                            <input type="text"
                                   onfocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})"
                                   id="logmax"
                                   class="input-text Wdate"
                                   name="end_date"
                                   @if (!empty($end_date)) value="{{$end_date}}" @endif>
                            <!-- 商品 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;商品：
                            <input type="text"
                                   class="input-text"
                                   name="product"
                                   @if (!empty($product)) value="{{$product}}" @endif>
                            <!-- 渠道选择 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="select-box inline">
                            <select name="channel" class="select">
                                <option value="2"
                                        @if (!empty($channel) && $channel == 2) selected @endif>
                                    全部渠道
                                </option>
                                <option value="{{\App\Order::DELIVER_EXPRESS}}"
                                        @if (!empty($channel) && $channel == \App\Order::DELIVER_EXPRESS) selected @endif>
                                    发货
                                </option>
                                <option value="{{\App\Order::DELIVER_SELF}}"
                                        @if (!empty($channel) && $channel == \App\Order::DELIVER_SELF) selected @endif>
                                    自提
                                </option>
                            </select>
                            </span>
                            <!-- 是否拼团选择 -->
                            <span class="select-box inline">
                            <select name="groupbuy" class="select">
                                <option value="0"
                                        @if (!empty($groupbuy) && $groupbuy == 0) selected @endif>
                                    是否拼团
                                </option>
                                <option value="1"
                                        @if (!empty($groupbuy) && $groupbuy == 1) selected @endif>
                                    拼团
                                </option>
                                <option value="2"
                                        @if (!empty($groupbuy) && $groupbuy == 2) selected @endif>
                                    非拼团
                                </option>
                            </select>
                            </span>
                        </div>
                        <div class="newline">
                            <!-- 门店 -->
                            <label for="store">门店：</label>
                            <input type="text"
                                   class="input-text"
                                   name="store"
                                   @if (!empty($store)) value="{{$store}}" @endif>
                            <!-- 用户名 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="name">用户名：</label>
                            <input type="text"
                                   class="input-text"
                                   name="name"
                                   @if (!empty($name)) value="{{$name}}" @endif>
                            <!-- 手机号 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="phone">手机号：</label>
                            <input type="text"
                                   class="input-text"
                                   name="phone"
                                   @if (!empty($phone)) value="{{$phone}}" @endif>
                            <!-- 订单状态 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="select-box inline">
                            <select name="status" class="select">
                                <option value="0"
                                        @if (!empty($status) && $status == 0) selected @endif>
                                    全部状态
                                </option>
                                @foreach (\App\Order::$STATUS_LIST as $st)
                                <option value="{{$st}}"
                                        @if (!empty($status) && $status == $st) selected @endif>
                                    {{\App\Order::getStatusName($st, \App\Order::DELIVER_EXPRESS)}}
                                </option>
                                @endforeach
                            </select>
                            </span>
                        </div>
                    </div>

                    <!-- 查询 -->
                    <button class="btn btn-success" type="submit">
                        <i class="Hui-iconfont">&#xe665;</i> 查询
                    </button>
                </div>
            </form>

            <div>
                <div class="pd-20">
                    <div class="cl pd-5 bg-1 bk-gray">
                        <span class="r">共有数据：<strong>{{count($orders)}}</strong> 条</span>
                    </div>
                    <div class="mt-20">
                        <table class="table table-border table-bordered table-bg table-hover table-sort">
                            <thead>
                            <tr class="text-c">
                                <th>订单号</th>
                                <th>商品</th>
                                <th>数量</th>
                                <th>规格</th>
                                <th>姓名</th>
                                <th>手机号</th>
                                <th>配送方式</th>
                                <th>门店</th>
                                <th>金额</th>
                                <th>订单状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $o)
                            <tr class="text-c va-m">
                                <td>{{$o->number}}</td>
                                <td>{{$o->product->name}}</td>
                                <td class="text-l">{{$o->count}}</td>
                                <td class="text-l">
                                    @if (!empty($o->spec))
                                    {{$o->spec->name}}
                                    @endif
                                </td>
                                <td class="text-l">{{$o->name}}</td>
                                <td class="text-l">{{$o->phone}}</td>
                                <td class="text-l">{{$o->getDeliveryName()}}</td>
                                <td class="text-l">
                                    @if (!empty($o->store))
                                    {{$o->store->name}}
                                    @endif
                                </td>
                                <td><span class="price">{{$o->price}}</span> 元</td>
                                <td class="td-status">{{\App\Order::getStatusName($o->status, $o->channel)}}</td>
                                <td class="td-manage">
                                    <a style="text-decoration:none"
                                       class="ml-5"
                                       href="{{url('/order/detail')}}/{{$o->id}}"
                                       title="编辑">
                                        <i class="Hui-iconfont">&#xe6df;</i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <ul id="pagination_data" class="pagination-sm pull-right"></ul>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">

    // 全局变量
    var gnTotalPage = '{{$orders->lastPage()}}';
    var gnCurrentPage = '{{$orders->currentPage()}}';

    gnTotalPage = parseInt(gnTotalPage);
    gnCurrentPage = parseInt(gnCurrentPage);

    $(document).ready(function(){
    });

</script>

<script type="text/javascript" src="<?=asset('lib/My97DatePicker/4.8/WdatePicker.js') ?>"></script>
<script type="text/javascript" src="<?=asset('/lib/pagination/jquery.twbsPagination.min.js')?>"></script>
<script type="text/javascript" src="<?=asset('/js/pagination.js')?>"></script>

@endsection