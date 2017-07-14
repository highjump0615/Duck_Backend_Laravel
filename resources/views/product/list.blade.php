@extends('layout.master')

@section('content')
    <?php
        $menu = 'product';
        $page = 'product.list';
    ?>
    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <div class="pos-a" style="width:150px;left:0;top:0; bottom:0; height:100%; border-right:1px solid #e5e5e5; background-color:#f5f5f5">
                <ul id="treeDemo" class="ztree">
                </ul>
            </div>
            <div style="margin-left:150px;">
                <div class="pd-20">
                    <div class="cl pd-5 bg-1 bk-gray">
					<span class="l">
						<a class="btn btn-primary radius" onclick="product_add('添加产品','{{url('/product/new')}}')" href="javascript:;">
						<i class="Hui-iconfont">&#xe600;</i> 添加产品</a>
					</span>
                        <span class="r">共有数据：<strong>54</strong> 条</span>
                    </div>
                    <div class="mt-20">
                        <table class="table table-border table-bordered table-bg table-hover table-sort">
                            <thead>
                            <tr class="text-c">
                                <th width="40" rowspan="2">ID</th>
                                <th width="60" rowspan="2">名称</th>
                                <th width="100" rowspan="2">分类</th>
                                <th rowspan="2">原价</th>
                                <th width="100" rowspan="2">运费</th>
                                <th colspan="3">拼团信息</th>
                                <th rowspan="2">库存</th>
                                <th width="100" rowspan="2">操作</th>
                            </tr>
                            <tr class="text-c">
                                <th>人数底线</th>
                                <th>拼团价</th>
                                <th>倒计时周期</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-c va-m">
                                @foreach($products as $p)
                                <td>{{$p->id}}</td>
                                <td>{{$p->name}}</td>
                                <td>{{$p->category_name}}</td>
                                <td><span class="price">{{$p->price}}</span></td>
                                <td><span class="price">{{$p->deliver_cost}}</span></td>
                                <td>{{$p->gb_count}}</td>
                                    <td>{{$p->gb_price}}</td>
                                    <td>{{$p->gb_timeout}}</td>
                                <td>{{$p->remain}}</td>
                                <td class="td-manage">
                                    <a style="text-decoration:none" onClick="product_stop(this,'10001')" href="javascript:;" title="下架">
                                        <i class="Hui-iconfont">&#xe6de;</i></a>
                                    <a style="text-decoration:none" class="ml-5" onClick="product_edit('产品编辑','{{url('/product')}}/{{$p->id}}/edit','10001')" href="javascript:;" title="编辑">
                                        <i class="Hui-iconfont">&#xe6df;</i></a>
                                    <a style="text-decoration:none" class="ml-5" onClick="product_del(this,'{{$p->id}}')" href="javascript:;" title="删除">
                                        <i class="Hui-iconfont">&#xe6e2;</i></a></td>
                                @endforeach
                            </tr>
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
        var setting = {
            view: {
                dblClickExpand: false,
                showLine: false,
                selectedMulti: false
            },
            data: {
                simpleData: {
                    enable:true,
                    idKey: "id",
                    pIdKey: "pId",
                    rootPId: ""
                }
            },
            callback: {
                beforeClick: function(treeId, treeNode) {
                    var zTree = $.fn.zTree.getZTreeObj("tree");
                    if (treeNode.isParent) {
                        zTree.expandNode(treeNode);
                        return false;
                    } else {
                        location.href=treeNode.file;
//                        demoIframe.attr("src",treeNode.file + ".html");
                        return true;
                    }
                }
            }
        };

        var zNodes =[
                @foreach($categories as $c)
            {  id:"{{$c->id}}", pId:0, name:"{{$c->name}}", file:"{{url('/products')}}?cat={{$c->id}}"},
                @endforeach
        ];

        var code;

        function showCode(str) {
            if (!code) code = $("#code");
            code.empty();
            code.append("<li>"+str+"</li>");
        }

        $(document).ready(function(){
            var t = $("#treeDemo");
            t = $.fn.zTree.init(t, setting, zNodes);
            demoIframe = $("#testIframe");
            demoIframe.bind("load", loadReady);
            var zTree = $.fn.zTree.getZTreeObj("tree");
            //zTree.selectNode(zTree.getNodeByParam("id",'1'));
        });

        function loadReady(){

        }

        $('.table-sort').dataTable({
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                {"orderable":false,"aTargets":[0,6]}// 制定列不参与排序
            ]
        });
        /*图片-添加*/
        function product_add(title,url){
            /*var index = layer.open({
             type: 2,
             title: title,
             content: url
             });
             layer.full(index);*/
            document.location = url;
        }
        /*图片-查看*/
        function product_show(title,url,id){
            // var index = layer.open({
            // 	type: 2,
            // 	title: title,
            // 	content: url
            // });
            // layer.full(index);
            document.location = url;
        }
        /*图片-审核*/
        function product_shenhe(obj,id){
            layer.confirm('审核文章？', {
                        btn: ['通过','不通过'],
                        shade: false
                    },
                    function(){
                        $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="product_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                        $(obj).remove();
                        layer.msg('已发布', {icon:6,time:1000});
                    },
                    function(){
                        $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="product_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
                        $(obj).remove();
                        layer.msg('未通过', {icon:5,time:1000});
                    });
        }
        /*图片-下架*/
        function product_stop(obj,id){
            layer.confirm('确认要下架吗？',function(index){
                $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_start(this,id)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
                $(obj).remove();
                layer.msg('已下架!',{icon: 5,time:1000});
            });
        }

        /*图片-发布*/
        function product_start(obj,id){
            layer.confirm('确认要发布吗？',function(index){
                $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_stop(this,id)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                $(obj).remove();
                layer.msg('已发布!',{icon: 6,time:1000});
            });
        }
        /*图片-申请上线*/
        function product_shenqing(obj,id){
            $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
            $(obj).parents("tr").find(".td-manage").html("");
            layer.msg('已提交申请，耐心等待审核!', {icon: 1,time:2000});
        }
        /*图片-编辑*/
        function product_edit(title,url,id){
            // var index = layer.open({
            // 	type: 2,
            // 	title: title,
            // 	content: url
            // });
            // layer.full(index);
            document.location = url;
        }
        /*图片-删除*/
        function product_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){

                    // 提交
                    $.ajax({
                        type: 'DELETE',
                        url: '{{url('/product')}}',
                        data: {
                            'product_id': id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (data) {
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!',{icon:1,time:1000});
                        },
                        error: function (data) {
//                            enableSubmit(true);
                            console.log(data);
                        }
                    });


            });
        }
    </script>
@endsection