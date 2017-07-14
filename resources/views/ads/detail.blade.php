@extends('layout.master')

@section('content')

    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box" style="overflow: auto;">
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 宣传管理 <span class="c-gray en">&gt;</span> 宣传详情
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
        <div class="page-container">
            <form action="{{url('/ad')}}" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if(isset($ad))
                    <input type="hidden" name="ad_id" value="{{$ad->id}}">
                @endif

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">图片：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <div class="uploader-thum-container">
                            <!--<div id="fileList" class="uploader-list"></div>
                            <div id="filePicker">选择图片</div>-->
                            <!--<button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">开始上传</button>-->
                            <input type='file' id="imgInp" name="image" />
                            <img id="blah" @if(isset($ad->image_full_path)) src="{{$ad->image_full_path}}" @endif
                                style="width:80px; height: 80px;" />
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">商品:</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <select class="select" name="product_id">
                            @foreach($products as $p)
                                @if(isset($ad) && $ad->product_id == $p->id)
                                    <option value="{{$p->id}}" selected>{{$p->name}}</option>
                                @else
                                    <option value="{{$p->id}}" >{{$p->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">开始时间:</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" onfocus="WdatePicker({})" id="logmin" class="input-text Wdate" style="width:120px;"
                            name="start_at" @if(isset($ad)) value="{{$ad->start_at}}" @endif>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">截止时间:</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}'})" id="logmax" class="input-text Wdate" style="width:120px;"
                            name="end_at"  @if(isset($ad)) value="{{$ad->end_at}}" @endif>
                    </div>
                </div>
                <div class="row cl" style="margin-top: 30px">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                        <button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                        <button onClick="onCancel();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('script')

    <script type="text/javascript" src="<?=asset('lib/My97DatePicker/4.8/WdatePicker.js') ?>"></script>
    <script type="text/javascript" src="<?=asset('lib/datatables/1.10.0/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?=asset('lib/laypage/1.2/laypage.js') ?>"></script>
    <script type="text/javascript">
        $(function(){
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imgInp").change(function(){
                readURL(this);
            });
        });

        $(function(){
        });

        function onCancel() {
            history.back();
        }

    </script>

@endsection