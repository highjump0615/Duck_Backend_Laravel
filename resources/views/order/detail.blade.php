@extends('layout.master')

@section('content')

    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 订单详情
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
        </nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <div id="tab-system" class="HuiTab">

                    <div class="tabBar cl">
                        <span class="current">订单详情</span>
                        <span>状态历史</span>
                    </div>

                    <!-- 订单详情 -->
                    <div class="tabCon" style="display: block">
                        <form action="{{url('/order')}}/{{$order->id}}" method="post" class="form form-horizontal" id="form-article-add">
                            {!! csrf_field() !!}
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">订单号：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <input type="text" value="{{$order->id}}" class="input-text" readonly>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">商品：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <div class="col-sm-4">
                                        <label class="form-label pull-left col-sm-4">名称</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" value="{{$order->product->name}}" class="input-text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label pull-left col-sm-4">分类</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" value="{{$order->product->category->name}}" class="input-text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label pull-left col-sm-4">数量</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" value="{{$order->count}}" class="input-text" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">收件人：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <div class="col-sm-4">
                                        <label class="form-label pull-left col-sm-4">姓名</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" value="{{$order->name}}" class="input-text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label pull-left col-sm-4">手机号</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" value="{{$order->phone}}" class="input-text" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">配送方式：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <div class="col-sm-4">
                                        <label class="form-label pull-left col-sm-4">渠道</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" value="{{$order->getDeliveryName()}}" class="input-text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <label class="form-label pull-left col-sm-2">地址</label>
                                        <div class="col-sm-10 pull-left">
                                            <input type="text" value="{{$order->address}}" class="input-text" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">拼团状态：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <div class="col-sm-4">
                                        <label class="form-label pull-left col-sm-4">人数</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text"
                                                   @if (!empty($order->groupBuy)) value="{{$order->groupBuy->getPeopleCount()}}" @endif
                                                   class="input-text"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label pull-left col-sm-4">倒计时</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text"
                                                   @if (!empty($order->groupBuy)) value="{{$order->groupBuy->end_at}} @endif"
                                                   class="input-text"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">支付金额：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <input type="text" value="{{$order->price}}" class="input-text" readonly>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">订单状态：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <input type="text" value="{{\App\Order::getStatusName($order->status)}}" class="input-text" readonly>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">发货快递单号：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <input name="deliver_code" type="text" value="{{$order->deliver_code}}" class="input-text">
                                </div>
                            </div>

                            <div class="row cl" style="margin-top: 30px">
                                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                                    <button class="btn btn-primary radius" type="submit">
                                        <i class="Hui-iconfont">&#xe632;</i> 保存并发货
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tabCon">
                        <table class="table table-border table-bordered table-bg table-hover" style="margin-top: 20px">
                            <thead>
                            <tr class="text-c">
                                <th width="40">序号</th>
                                <th>时间</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no=0; ?>
                            @foreach($order->histories as $h)
                                <?php $no++; ?>
                            <tr class="text-c va-m">
                                <td>{{$no}}</td>
                                <td>{{$h->created_at}}</td>
                                <td>{{$h->status_str}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
        </div>
    </section>

@endsection

@section('script')

    <script type="text/javascript">
        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
            $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click","0");
        });
    </script>

@endsection