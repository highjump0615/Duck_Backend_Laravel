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
                    <textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,100)">@if(isset($category)){{$category->desc}}@endif</textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
                </div>
                <div class="col-5"> </div>
            </div>
            <div class="row cl">
                <div class="col-9 col-offset-2">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')

    <script>
        $('#form-category-add').submit(function (e) {
            e.preventDefault();

            // 提交
            $.ajax({
                type: 'POST',
                url: '{{'/category'}}',
                data: $(this).serializeArray(),
                success: function (data) {
                    parent.location.reload();
                },
                error: function (data) {
                    enableSubmit(true);
                    console.log(data);
                }
            });

            enableSubmit(false);
        });
    </script>
@endsection