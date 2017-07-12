@extends('layout.master')

@section('content')
<section class="Hui-article-box">
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 주문관리 <span class="c-gray en">&gt;</span> 주문목록 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="Hui-article">
        <div>
            <div class="pd-20">
                <div class="cl pd-5 bg-1 bk-gray">
					<span class="l">
						<a class="btn btn-primary radius" onclick="product_add('添加产品','order-detail.php')" href="javascript:;">
						<i class="Hui-iconfont">&#xe600;</i> 添加产品</a>
					</span>
                    <span class="r">共有数据：<strong>54</strong> 条</span>
                </div>
                <div class="mt-20">
                    <table class="table table-border table-bordered table-bg table-hover table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="40">주문번호</th>
                            <th>상품이름</th>
                            <th width="100">분류</th>
                            <th width="60">수량</th>
                            <th width="100">규격</th>
                            <th width="60">이름</th>
                            <th width="100">전화번호</th>
                            <th width="100">배달방식</th>
                            <th width="100">그룹상태</th>
                            <th width="100">그룹정보</th>
                            <th width="100">지불상태</th>
                            <th width="100">지불금액</th>
                            <th width="100">주문상태</th>
                            <th width="100">주문리력</th>
                            <th width="100">운송번호</th>
                            <th width="100">비고</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c va-m">
                            <td>001</td>
                            <td>상품1</td>
                            <td class="text-l">분류1</td>
                            <td class="text-l">수량</td>
                            <td class="text-l">규격</td>
                            <td class="text-l">이름</td>
                            <td class="text-l">전화번호</td>
                            <td class="text-l">배달방식</td>
                            <td class="text-l">그룹상태</td>
                            <td class="text-l">그룹정보</td>
                            <td class="text-l">지불상태</td>
                            <td><span class="price">356.0</span> 元</td>
                            <td class="td-status">주문상태</td>
                            <td><a onClick="orderhistory_show('哥本哈根橡木地板','order-history.php','10001')" href="javascript:;">주문리력</a></td>
                            <td class="text-l">운송번호</td>
                            <td class="text-l">비고</td>
                            <td class="td-manage"><a style="text-decoration:none" onClick="product_stop(this,'10001')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_edit('产品编辑','order-detail.php','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_del(this,'10001')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">

    var code;

    function showCode(str) {
        if (!code) code = $("#code");
        code.empty();
        code.append("<li>"+str+"</li>");
    }

    $(document).ready(function(){
    });

    function loadReady(){

    }

    $('.table-sort').dataTable({
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "aoColumnDefs": [
            {"orderable":false,"aTargets":[0,16]}// 制定列不参与排序
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
    function orderhistory_show(title,url,id){
        layer_show(title, url, 900, 400)
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
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
        });
    }
</script>
@endsection