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
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i>首页
            <span class="c-gray en">&gt;</span> 商品管理
            <span class="c-gray en">&gt;</span> 商品分类
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
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
    <script type="text/javascript" src="<?=asset('lib/zTree/v3/js/jquery.ztree.all.min.js')?>"></script>
    <script type="text/javascript">
        var nodeSelected;
        var setting = {
            view: {
                dblClickExpand: false,
                showLine: false,
                selectedMulti: false
            },
            edit: {
                enable: true,
                showRemoveBtn: false,
                showRenameBtn: false,
                drag: {
                    isMove: true,
                    isCopy: false,
                    prev: true,
                    next: true,
                    inner: false
                }
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
                },
                beforeDrop: onDropTree,
                // 限制有的字段不能动
                beforeDrag: function(treeId, treeNode) {
                    // 保存选中的node
                    var zTree = $.fn.zTree.getZTreeObj(treeId);
                    nodeSelected = zTree.getSelectedNodes();

                    for (var i = 0; i < treeNode.length; i++) {
                        if (treeNode[i].drag === false) {
                            return false;
                        }
                    }
                    return true;
                },
                onDrop: function(event, treeId, treeNodes, targetNode, moveType, isCopy) {
                    // 保持原来的选择
                    var zTree = $.fn.zTree.getZTreeObj(treeId);
                    if (nodeSelected && nodeSelected.length > 0) {
                        zTree.selectNode(nodeSelected[0]);
                    }
                    else {
                        zTree.cancelSelectedNode(treeNodes[0]);
                    }
                }
            }
        };

        /**
         * 分类顺序有变化
         * @param event
         * @param treeId
         * @param treeNodes
         * @param targetNode
         * @param moveType
         * @param isCopy
         * @returns {boolean}
         */
        function onDropTree(treeId, treeNodes, targetNode, moveType, isCopy) {
            if (targetNode.drop === false) {
                return false;
            }

            // 没有拖拽对象
            if (treeNodes.length <= 0) {
                return false;
            }

            // 拖拽无效
            if (!moveType) {
                return false;
            }

            // 把prev转换成next
            var nTargetId = targetNode.id;
            if (moveType === 'prev') {
                var nIndex = zTree.getNodeIndex(targetNode);
                if (nIndex > 0) {
                    nTargetId = zNodes[nIndex-1].id;
                }
                else {
                    nTargetId = 0;
                }
            }

            // 设置顺序
            $.ajax({
                type: 'POST',
                url: '{{url('/category/updateOrder')}}',
                data: {
                    'object_id': treeNodes[0].id,
                    'target_id': nTargetId,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data) {
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        var zNodes =[
                @foreach($categories as $c)
            { id:{{$c->id}}, pId:0, name:"{{$c->name}}", open:true, file:"{{url('/category_add')}}?cat={{$c->id}}"},
                @endforeach
            { id:-1, pId:0, name:"新建...", file:"{{url('/category_add')}}", drop: false, drag: false},
        ];

        $(document).ready(function(){
            var t = $("#treeDemo");
            t = $.fn.zTree.init(t, setting, zNodes);

            demoIframe = $("#testIframe");
        });
    </script>

@endsection