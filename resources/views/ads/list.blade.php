@extends('layout.master')

@section('content')

    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <!-- 面包屑 -->
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 宣传管理 <span class="c-gray en">&gt;</span> 宣传列表
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
        </nav>

        <div class="Hui-article">
            <div>
                <div class="pd-20">
                    <div class="cl pd-5 bg-1 bk-gray">
					<span class="l">
						<a class="btn btn-primary radius" href="{{url('/ads/add')}}">
						    <i class="Hui-iconfont">&#xe600;</i> 添加宣传
                        </a>
					</span>
                        <span class="r">共有数据：<strong>{{count($ads)}}</strong> 条</span>
                    </div>
                    <div class="mt-20">
                        <table class="table table-border table-bordered table-bg table-hover">
                            <thead>
                            <tr class="text-c">
                                <th width="40">序号</th>
                                <th width="60">图片</th>
                                <th width="100">商品</th>
                                <th width="120">开始时间</th>
                                <th width="120">截止时间</th>
                                <th width="100">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ads as $a)
                            <tr class="text-c va-m">
                                <td>{{$a->id}}</td>
                                <td><img width="60" class="product-thumb" src="{{$a->image_full_path}}"></td>
                                <td class="text-l">{{$a->product->name}}</td>
                                <td class="text-l">{{$a->start_at}}</td>
                                <td class="text-l">{{$a->end_at}}</td>
                                <td class="td-manage">
                                    <a style="text-decoration:none" class="ml-5" href="{{url('/ads/detail/')}}/{{$a->id}}" title="编辑">
                                        <i class="Hui-iconfont">&#xe6df;</i>
                                    </a>
                                    <a style="text-decoration:none" class="ml-5" onClick="product_del(this, '{{$a->id}}')" href="javascript:;" title="删除">
                                        <i class="Hui-iconfont">&#xe6e2;</i>
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

    <script type="text/javascript">

        $(document).ready(function(){
        });

        /*图片-删除*/
        function product_del(obj, id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'DELETE',
                    url: '{{url('/ad')}}',
                    data: {
                        'ad_id': id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        }
    </script>

@endsection