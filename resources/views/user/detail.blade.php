@extends('layout.master')

@section('content')

    <article class="cl pd-20">
        <form action="/user/save" method="post" class="form form-horizontal" id="form-admin-add">
            @if (!empty($user))
            <input type="hidden" name="userid" value="{{$user->id}}">
            @endif
            {{ csrf_field() }}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"
                           class="input-text"
                           @if (!empty($user)) value="{{$user->username}}" @endif
                           placeholder="用户名"
                           id="adminName"
                           name="username">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password"
                           class="input-text"
                           autocomplete="off"
                           value=""
                           placeholder="密码"
                           id="password"
                           name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password"
                           class="input-text"
                           autocomplete="off"
                           placeholder="确认新密码"
                           id="password2"
                           name="password2">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"
                           class="input-text"
                           placeholder="@"
                           @if (!empty($user)) value="{{$user->email}}" @endif
                           name="email"
                           id="email">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">角色：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="role" size="1">
                    @foreach ($roles as $role)
					<option value="{{$role->id}}"
                            @if (!empty($user) && $role->id == $user->role_id) selected @endif>
                        {{$role->name}}
                    </option>
                    @endforeach
				</select>
				</span> </div>
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

            $('#form-admin-add').submit(function (e) {
                e.preventDefault();

                // 提交
                $.ajax({
                    type: 'POST',
                    url: '/user/save',
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

            $("#form-admin-add").validate({
                rules:{
                    username:{
                        required:true,
                        minlength:4,
                        maxlength:16
                    },
                    @if (empty($user))
                    password:{
                        required:true,
                    },
                    password2:{
                        required:true,
                        equalTo: "#password"
                    },
                    @endif
                    email:{
                        required:true,
                        email:true,
                    },
                    role:{
                        required:true,
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
            });
        });
    </script>

@endsection