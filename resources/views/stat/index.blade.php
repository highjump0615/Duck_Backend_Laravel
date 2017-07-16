@extends('layout.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="<?=asset('lib/chosen/chosen.min.css') ?>" />
@endsection

@section('content')

    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
            <span class="c-gray en">&gt;</span>
            数据统计
            <span class="c-gray en">&gt;</span>
            自定义查询
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <form action="{{url('/stat')}}" method="get">
                <div class="text-c">
                    <!-- 商品选择 -->
                    <span class="select-box inline">
                    <select name="product" class="select">
                        <option value="0"
                                @if (!empty($product) && $product == 0) selected @endif>
                            全部商品
                        </option>
                        @foreach ($products as $p)
                        <option value="{{$p->id}}"
                                @if (!empty($product) && $product == $p->id) selected @endif>
                            {{$p->name}}
                        </option>
                        @endforeach
                    </select>
                    </span>
                    <!-- 日期范围 -->
                    &nbsp;&nbsp;&nbsp;&nbsp;日期范围：
                    <input type="text"
                           onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})"
                           id="logmin"
                           class="input-text Wdate"
                           name="start_date"
                           @if (!empty($start_date)) value="{{$start_date}}" @endif
                           style="width:120px;">
                    -
                    <input type="text"
                           onfocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})"
                           id="logmax"
                           class="input-text Wdate"
                           name="end_date"
                           @if (!empty($end_date)) value="{{$end_date}}" @endif
                           style="width:120px;">
                    <!-- 门店选择 -->
                    <select name="store[]" data-placeholder="门店" class="chosen-select" style="width:250px"  multiple>
                        @foreach ($stores as $s)
                            <?php
                            $bExist = false;
                            foreach ($store as $sid) {
                                if ($sid == $s->id) {
                                    $bExist = true;
                                    break;
                                }
                            }
                            ?>
                            <option value="{{$s->id}}"
                                    @if ($bExist) selected @endif>
                                {{$s->name}}
                            </option>
                        @endforeach
                    </select>
                    <!-- 渠道选择 -->
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
                    <button class="btn btn-success" type="submit">
                        <i class="Hui-iconfont">&#xe665;</i> 查询
                    </button>
                </div>
                </form>
                <div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
				</span>
                    <span class="r">共有数据：<strong>1</strong> 条</span>
                </div>
                <div class="mt-20">
                    <table class="table table-border table-bordered table-bg table-hover">
                        <thead>
                        <tr class="text-c">
                            <th>销售数量</th>
                            <th>金额</th>
                            <th>订单数</th>
                            <th>退货量</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c">
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>


@endsection

@section('script')
    <script type="text/javascript" src="<?=asset('lib/My97DatePicker/4.8/WdatePicker.js') ?>"></script>
    <script type="text/javascript" src="<?=asset('lib/datatables/1.10.0/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?=asset('lib/laypage/1.2/laypage.js') ?>"></script>
    <script type="text/javascript" src="<?=asset('lib/chosen/chosen.jquery.min.js') ?>"></script>
    <script type="text/javascript">

        $('.chosen-select').chosen();
        $(function(){

        });
    </script>
@endsection