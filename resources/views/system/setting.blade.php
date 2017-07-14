@extends('layout.master')

@section('content')

    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box">
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i> 首页
            <span class="c-gray en">&gt;</span> 系统管理
            <span class="c-gray en">&gt;</span> 系统设置
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
        <article class="cl pd-20">
            <form action="{{url('/setting')}}" method="post" class="form form-horizontal" id="form-admin-add">
                {{ csrf_field() }}
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">客户电话：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text"
                               class="input-text"
                               name="service_phone">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">包退提示：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <textarea name="desc" cols="" rows="" class="textarea"  datatype="*10-100" dragonfly="true" nullmsg="提示不能为空！" onKeyUp="textarealength(this,100)">
                        </textarea>
                    </div>
                    <div class="col-5"> </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">拼团提示：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <textarea name="desc" cols="" rows="" class="textarea"  datatype="*10-100" dragonfly="true" nullmsg="提示不能为空！" onKeyUp="textarealength(this,100)">
                        </textarea>
                    </div>
                    <div class="col-5"> </div>
                </div>

                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </article>
    </section>

@endsection

@section('script')
@endsection
