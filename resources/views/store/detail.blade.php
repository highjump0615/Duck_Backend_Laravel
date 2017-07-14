@extends('layout.master')

@section('content')

    <article class="cl pd-20">
        <form action="{{url('/store')}}" method="post" class="form form-horizontal" id="form-store-add">
            @if (isset($store))
                <input type="hidden" name="store_id" value="{{$store->id}}">
            @endif
            {{ csrf_field() }}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">门店名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"
                           class="input-text"
                           @if (!empty($store)) value="{{$store->name}}" @endif
                           name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"
                           class="input-text"
                           @if (!empty($store)) value="{{$store->address}}" @endif
                           name="address">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">位置：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="col-sm-6">
                        <input type="text" name="longitude" @if(!empty($store)) value="{{$store->longitude}}" @endif placeholder="经度" value="" class="input-text" onkeypress='validate(event)'>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="latitude" @if(!empty($store)) value="{{$store->latitude}}" @endif placeholder="维度" value="" class="input-text" onkeypress='validate(event)'>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">联系电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"
                           class="input-text"
                           @if (!empty($store)) value="{{$store->phone}}" @endif
                           name="phone">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius disabled" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" disabled>
                </div>
            </div>
        </form>
    </article>

@endsection

@section('script')

    <script type="text/javascript" src="<?=asset('lib/jquery.validation/1.14.0/jquery.validate.js') ?>"></script>
    <script type="text/javascript" src="<?=asset('lib/jquery.validation/1.14.0/validate-methods.js') ?>"></script>
    <script type="text/javascript" src="<?=asset('lib/jquery.validation/1.14.0/messages_zh.js') ?>"></script>


    <script type="text/javascript">
        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        function enableSubmit(enable) {
            var objSubmit = $('input[type = submit]');
            if (enable) {
                objSubmit.removeClass('disabled');
                objSubmit.removeAttr('disabled');
            }
            else {
                objSubmit.addClass('disabled');
                objSubmit.attr('disabled');
            }
        }

        $(function(){
            enableSubmit(true);

            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $('#form-store-add').submit(function (e) {
                e.preventDefault();

                // 提交
                $.ajax({
                    type: 'POST',
                    url: '/store',
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

            $("#form-store-add").validate({
                rules:{
                    name:{
                        required:true
                    },
                    phone:{
                        required:true
                    },
                    address:{
                        required:true
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid"
            });
        });
    </script>

@endsection