@extends('layout.master')

@section('style')
    <link rel="stylesheet" href="<?=asset('lib/zTree/v3/css/zTreeStyle/zTreeStyle.css')?>" type="text/css">
@endsection

@section('content')

    <?php
        $menu = 'product';
        $page = 'product.category';
    ?>
    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商品管理 <span class="c-gray en">&gt;</span> 商品分类 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="Hui-article">
            <article class="cl pd-20">
                <table class="table">
                    <tr>
                        <td width="200" class="va-t"><ul id="treeDemo" class="ztree"></ul></td>
                        <td class="va-t"><iframe ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width=100%  height=390px SRC="{{url('/category_add')}}"></iframe></td>
                    </tr>
                </table>
            </article>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript" src="<?=asset('lib/zTree/v3/js/jquery.ztree.all-3.5.min.js')?>"></script>
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
                        demoIframe.attr("src",treeNode.file);
                        return true;
                    }
                }
            }
        };

        var zNodes =[
                @foreach($categories as $c)
            { id:0, pId:0, name:"{{$c->name}}", open:true, file:"{{url('/category_add')}}?cat={{$c->id}}"},
                @endforeach
            { id:0, pId:0, name:"New...", file:"{{url('/category_add')}}"},

        ];

        var code;

        function loadReady(){

        }

        $(document).ready(function(){
            var t = $("#treeDemo");
            t = $.fn.zTree.init(t, setting, zNodes);
            demoIframe = $("#testIframe");
            demoIframe.bind("load", loadReady);
            var zTree = $.fn.zTree.getZTreeObj("tree");
            //zTree.selectNode(zTree.getNodeByParam("id",'1'));
        });
    </script>

@endsection