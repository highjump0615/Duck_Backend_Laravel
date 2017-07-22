@extends('layout.master')

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

            <form action="{{url('/stat')}}" method="get">
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
                                   name="product">
                            <!-- 渠道选择 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="select-box inline">
                            <select name="channel" class="select">
                                <option value="2"
                                        @if (!empty($channel) && $channel == 2) selected @endif>
                                    全部渠道
                                </option>
                                <option value="0"
                                        @if (!empty($channel) && $channel == 0) selected @endif>
                                    发货
                                </option>
                                <option value="1"
                                        @if (!empty($channel) && $channel == 1) selected @endif>
                                    自提
                                </option>
                            </select>
                            </span>
                            <!-- 是否拼团选择 -->
                            <span class="select-box inline">
                            <select name="channel" class="select">
                                <option value="2"
                                        @if (!empty($channel) && $channel == 2) selected @endif>
                                    是否拼团
                                </option>
                                <option value="0"
                                        @if (!empty($channel) && $channel == 0) selected @endif>
                                    拼团
                                </option>
                                <option value="1"
                                        @if (!empty($channel) && $channel == 1) selected @endif>
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
                                   name="store">
                            <!-- 用户名 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="name">用户名：</label>
                            <input type="text"
                                   class="input-text"
                                   name="name">
                            <!-- 手机号 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="phone">手机号：</label>
                            <input type="text"
                                   class="input-text"
                                   name="phone">
                            <!-- 订单状态 -->
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="select-box inline">
                            <select name="channel" class="select">
                                <option value="2"
                                        @if (!empty($channel) && $channel == 2) selected @endif>
                                    全部状态
                                </option>
                                <option value="0"
                                        @if (!empty($channel) && $channel == 0) selected @endif>
                                    发货
                                </option>
                                <option value="1"
                                        @if (!empty($channel) && $channel == 1) selected @endif>
                                    自提
                                </option>
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
                                <th width="40">订单号</th>
                                <th>商品</th>
                                <th width="60">数量</th>
                                <th width="100">规格</th>
                                <th width="60">姓名</th>
                                <th width="100">手机号</th>
                                <th width="100">配送方式</th>
                                <th width="100">金额</th>
                                <th width="100">订单状态</th>
                                <th width="100">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $o)
                            <tr class="text-c va-m">
                                <td>{{$o->id}}</td>
                                <td>{{$o->product->name}}</td>
                                <td class="text-l">{{$o->count}}</td>
                                <td class="text-l">{{$o->spec->name}}</td>
                                <td class="text-l">{{$o->name}}</td>
                                <td class="text-l">{{$o->phone}}</td>
                                <td class="text-l">{{$o->getDeliveryName()}}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="<?=asset('lib/datatables/1.10.0/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript">

    $(document).ready(function(){
    });

    $('.table-sort').dataTable({
        'ordering': false
    });

</script>
@endsection