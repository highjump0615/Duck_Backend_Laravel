@extends('layout.master')

@section('content')

    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i> 首页
            <span class="c-gray en">&gt;</span> 管理员管理
            <span class="c-gray en">&gt;</span> 管理员列表
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <div class="cl pd-5 bg-1 bk-gray">
				<span class="l">
					<a href="javascript:;" onclick="admin_add('添加管理员','/user/add','800','400')" class="btn btn-primary radius">
                        <i class="Hui-iconfont">&#xe600;</i> 添加管理员
                    </a>
				</span>
                    <span class="r">共有数据：<strong>{{count($users)}}</strong> 条</span>
                </div>
                <div class="mt-10">
                    <table class="table table-border table-bordered table-bg">
                        <thead>
                        <tr>
                            <th scope="col" colspan="6">管理员列表</th>
                        </tr>
                        <tr class="text-c">
                            <th width="40">ID</th>
                            <th width="150">登录名</th>
                            <th width="150">邮箱</th>
                            <th>角色</th>
                            <th width="130">加入时间</th>
                            <th width="100">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                        @foreach ($users as $user)
                            <?php $i++; ?>
                            <tr class="text-c" data-userid="{{$user->id}}">
                                <td>{{$i}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role->name}}</td>
                                <td>{{$user->created_at}}</td>
                                <td class="td-manage">
                                    <a title="编辑"
                                       href="javascript:;"
                                       onclick="admin_edit('管理员编辑','/user/detail/{{$user->id}}','1','800','400')"
                                       class="ml-5"
                                       style="text-decoration:none">
                                        <i class="Hui-iconfont">&#xe6df;</i>
                                    </a>
                                    <!-- 不能删除admin账号 -->
                                    @if ($user->id > 1)
                                    <a title="删除" href="javascript:;" onclick="admin_del(this,'1')" class="ml-5" style="text-decoration:none">
                                        <i class="Hui-iconfont">&#xe6e2;</i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
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
        function admin_del(obj,id){
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