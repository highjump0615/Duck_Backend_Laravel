@extends('layout.master')

@section('content')

    <div class="pd-20">
        <form action="{{url('category')}}" method="post" class="form form-horizontal" id="form-category-add">
            {{ csrf_field() }}
            @if(isset($category))
                <input type="hidden" name="cat" value="{{$category->id}}">
            @endif
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类名称：</label>
                <div class="formControls col-5">
                    <input type="text" class="input-text" placeholder="" id="user-name" name="name"
                        @if(isset($category)) value="{{$category->name}}" @endif>
                </div>
                <div class="col-5"> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">备注：</label>
                <div class="formControls col-5">
                    <textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！">@if(isset($category)){{$category->desc}}@endif</textarea>
                </div>
                <div class="col-5"> </div>
            </div>
        </form>

        <div class="row cl mt-20">
            <div class="col-5 text-c">
                <button id="but-submit" class="btn btn-primary radius">&nbsp;&nbsp;提交&nbsp;&nbsp;</button>
                <button id="but-delete" class="btn radius ml-15">&nbsp;&nbsp;删除&nbsp;&nbsp;</button>
            </div>
        </div>

    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {
            var objForm = $("#form-category-add");

            objForm.submit(function (e) {
                e.preventDefault();

                // 提交
                $.ajax({
                    type: 'POST',
                    url: '{{url("/category")}}',
                    data: $(this).serializeArray(),
                    success: function (data) {
                        parent.location.reload();
//                    console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $("#but-delete").click(function (e) {
                e.preventDefault();

                @if (!empty($category))
                layer.confirm('确认要删除吗？', {shade: false}, function(){
                    // 提交
                    $.ajax({
                        type: 'DELETE',
                        url: '{{url('/category')}}',
                        data: {
                            'id': '{{$category->id}}',
                            "_token": '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            parent.location.reload();
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });
                @endif
            });

            $("#but-submit").click(function (e) {
                // 检查名称有内容
                if ($('input[name="name"]').val().length <= 0) {
                    layer.msg('请输入名称');
                    return;
                }

                objForm.submit();
            });
        });
    </script>
@endsection