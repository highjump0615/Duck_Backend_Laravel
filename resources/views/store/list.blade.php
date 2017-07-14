@extends('layout.master')

@section('content')

    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i> 首页
            <span class="c-gray en">&gt;</span> 门店管理
            <span class="c-gray en">&gt;</span> 门店列表
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <div class="cl pd-5 bg-1 bk-gray">
				<span class="l">
					<a href="javascript:;" onclick="admin_add('添加门店','/store/add','800','400')" class="btn btn-primary radius">
                        <i class="Hui-iconfont">&#xe600;</i> 添加门店
                    </a>
				</span>
                    <span class="r">共有数据：<strong>23</strong> 条</span>
                </div>
                <div class="mt-10">
                    <table class="table table-border table-bordered table-bg">
                        <thead>
                        <tr class="text-c">
                            <th width="40">序号</th>
                            <th>名称</th>
                            <th>地址</th>
                            <th>联系电话</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <tr class="text-c">
                                <td>1</td>
                                <td>阿斯蒂芬离开</td>
                                <td>的脸孔王培荣 数量的看法</td>
                                <td>2340239384</td>
                                <td class="td-manage">
                                    <a title="编辑"
                                       href="javascript:;"
                                       onclick="admin_edit('门店编辑','/store/detail/3','1','800','400')"
                                       class="ml-5"
                                       style="text-decoration:none">
                                        <i class="Hui-iconfont">&#xe6df;</i>
                                    </a>
                                    <a title="删除" href="javascript:;" onclick="admin_del(this)" class="ml-5" style="text-decoration:none">
                                        <i class="Hui-iconfont">&#xe6e2;</i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript" src="<?=asset('lib/datatables/1.10.0/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?=asset('lib/laypage/1.2/laypage.js') ?>"></script>
    <script type="text/javascript">
        /*
         参数解释：
         title	标题
         url		请求的url
         id		需要操作的数据id
         w		弹出层宽度（缺省调默认值）
         h		弹出层高度（缺省调默认值）
         */
        /*管理员-增加*/
        function admin_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-删除*/
        function admin_del(obj){
            layer.confirm('确认要删除吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……

                var trObj = $(obj).parents("tr");
                var nId = trObj.data('userid');

                // 删除
                $.ajax({
                    type: 'GET',
                    url: '/user/remove/' + nId,
                    data: {},
                    success: function (data) {
                        trObj.remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        }
        /*管理员-编辑*/
        function admin_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
    </script>

@endsection