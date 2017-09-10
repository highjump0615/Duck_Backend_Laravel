@extends('layout.master')

@section('style')
    <style>
        .prod-spec > label {
            padding-right: 10px;
        }

        .prod-spec > label a {
            text-decoration: none;
            visibility: hidden;
        }

        .add-spec {
            margin-top: 10px;
        }
    </style>
    <link href="<?=asset('lib/webuploader/0.1.5/webuploader.css')?>" rel="stylesheet" type="text/css"/>

@endsection
@section('content')

    <?php
    $menu = 'product';
    $page = 'product.list';
    ?>
    @include('layout.header')
    @include('layout.sidemenu')

    <section class="Hui-article-box" style="overflow: auto;">
        <!-- 面包屑 -->
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
            <span class="c-gray en">&gt;</span> 商品管理
            <span class="c-gray en">&gt;</span> 商品
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>

        <div class="page-container">
            <form class="form form-horizontal" id="form-product" enctype="multipart/form-data">
                {{ csrf_field() }}
                @if(isset($product))
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                @endif

                <!-- 名称 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品标题：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text"
                               class="input-text"
                               onkeyup="$.Huitextarealength(this, 20)"
                               @if(isset($product)) value="{{$product->name}}" @endif
                               name="name">
                        <p class="textarea-numberbar">
                            @if (!empty($product))
                                <em class="textarea-length">{{strlen($product->name)}}</em>/20
                            @else
                                <em class="textarea-length">0</em>/20
                            @endif
                        </p>
                    </div>
                </div>

                <!-- 分类 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <span class="select-box">
                           <select name="category_id" class="select">
                               @foreach($categories as $c)
                                   @if(isset($product) && $product->category_id == $c->id)
                                       <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                   @else
                                       <option value="{{$c->id}}">{{$c->name}}</option>
                                   @endif
                               @endforeach
                           </select>
                       </span>
                    </div>
                </div>

                <!-- 规格 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">商品规格：</label>
                    <!-- 规格列表 -->
                    <div class="formControls col-xs-8 col-sm-9">
                        <div class="prod-spec">
                            @foreach($specs as $s)
                                <label class="">
                                    @if(isset($product) && $product->hasSpec($s->id))
                                        <input type="checkbox" value="1" name="spec{{$s->id}}" checked />
                                    @else
                                        <input type="checkbox" value="1" name="spec{{$s->id}}" />
                                    @endif
                                    {{$s->name}}
                                    <a data-spec="{{$s->id}}"><i class="Hui-iconfont">&#xe6a6;</i></a>
                                </label>
                            @endforeach
                        </div>
                        <!-- 添加规格 -->
                        <div class="add-spec">
                            <input type="text" id="rule-name" class="input-text" value="" placeholder="添加规格"
                                   style="width:200px;">
                            <input type="button" id="btn-rule-add" class="btn btn-default" value="添加">
                        </div>
                    </div>
                </div>

                <!-- 原价 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">原价：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" name="price" id="price" placeholder=""
                               @if(isset($product)) value="{{$product->price}}" @endif class="input-text"
                               style="width:80%">
                        元
                    </div>
                </div>

                <!-- 运费 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">运费：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" name="deliver_cost" id="" placeholder=""
                               @if(isset($product)) value="{{$product->deliver_cost}}" @endif class="input-text"
                               style="width:80%">
                        元
                    </div>
                </div>

                <!-- 库存 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">库存：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" style="width:180px;" name="remain"
                               @if(isset($product)) value="{{$product->remain}}" @endif>
                    </div>
                </div>

                <!-- 拼团设置 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">拼团设置</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text"
                               name="gb_count"
                               placeholder="输入人数底线"
                               @if(isset($product)) value="{{$product->gb_count}}" @endif
                               class="input-text"
                               style=" width:20%">
                        人&nbsp;&nbsp;&nbsp;
                        <input type="text"
                               name="gb_price"
                               placeholder="输入拼团价"
                               @if(isset($product)) value="{{$product->gb_price}}" @endif
                               class="input-text"
                               style=" width:20%">
                        元&nbsp;&nbsp;&nbsp;
                        <input type="text"
                               name="gb_timeout"
                               placeholder="输入倒计时"
                               @if(isset($product)) value="{{$product->gb_timeout}}" @endif
                               class="input-text"
                               style=" width:20%">
                        小时
                    </div>
                </div>

                <!-- 缩略图 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <div class="uploader-thum-container">
                            <input type="file" id="imgInp"/>
                            <img id="blah"
                                 style="width:80px; height: 80px;"
                                 @if (!empty($product)) src="{{$product->getThumbnailUrl()}}" @endif />
                        </div>
                    </div>
                </div>

                <!-- 图片 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">图片上传：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <div class="uploader-list-container">
                            <div class="queueList">
                                <div id="dndArea" class="placeholder">
                                    <div id="filePicker-2"></div>
                                    <p>或将照片拖到这里，单次最多可选300张</p>
                                </div>
                            </div>
                            <div class="statusBar" style="display:none;">
                                <div class="progress"><span class="text">0%</span> <span class="percentage"></span>
                                </div>
                                <div class="info"></div>
                                <div class="btns">
                                    <div id="filePicker2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 详细内容 -->
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">详细内容：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <script id="editor" type="text/plain" ></script>
                    </div>
                </div>

            </form>

            <!-- 提交按钮 -->
            <div class="row cl mt-30">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button id="butSubmit" class="btn btn-primary radius">
                        <i class="Hui-iconfont">&#xe632;</i>
                        <span>保存并提交</span>
                    </button>
                    <button onClick="onCancel();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript" src="<?=asset('lib/jquery.validation/1.14.0/jquery.validate.js')?>"></script>
    <script type="text/javascript" src="<?=asset('lib/jquery.validation/1.14.0/validate-methods.js')?>"></script>
    <script type="text/javascript" src="<?=asset('lib/jquery.validation/1.14.0/messages_zh.js')?>"></script>

    <script type="text/javascript" src="<?=asset('lib/webuploader/0.1.5/webuploader.min.js')?>"></script>

    <script type="text/javascript" src="<?=asset('lib/ueditor/1.4.3/ueditor.config.js')?>"></script>
    <script type="text/javascript" src="<?=asset('lib/ueditor/1.4.3/ueditor.all.min.js')?>"></script>
    <script type="text/javascript" src="<?=asset('lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js')?>"></script>

    <script>

        // 添加validate规则
        $.validator.addMethod(
            'fractionLimit',
            function (value, element, requiredValue) {
                // 如果输入的整数，直接通过
                if (value % 1 === 0) {
                    return true;
                }

                // 小数，检查位数
                var nDigits = value.toString().split('.')[1].length;
                return nDigits <= requiredValue;
            },
            '不能输入2位以上小数'
        );

        // WebUploader实例
        var uploader;

        var getFileBlob = function (url, cb) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", url);
            xhr.responseType = "blob";
            xhr.addEventListener('load', function() {
                cb(xhr.response);
            });
            xhr.send();
        };

        var blobToFile = function (blob, name) {
            blob.lastModifiedDate = new Date();
            blob.name = name;
            return blob;
        };

        var getFileObject = function(filePathOrUrl, cb) {
            getFileBlob(filePathOrUrl, function (blob) {
                cb(blobToFile(blob, Math.floor((Math.random() * 1000) + 1)));
            });
        };

        function setDeleteSpec() {
            //
            // 删除规格
            //
            $('.prod-spec > label').hover(function() {
                $(this).find('a').css('visibility', 'visible');
            }, function() {
                $(this).find('a').css('visibility', 'hidden');
            });

            $('.prod-spec > label a').click(function(e) {
                e.preventDefault();

                var nSpecId = $(this).data('spec');
                var objSpec = $(this).parent();

                layer.confirm('确定删除此规格吗？', function(index) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{url('/rule')}}',
                        data: {
                            'id': nSpecId,
                            "_token": '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            // 删除该规格
                            objSpec.remove();
                            layer.close(index);
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });
            });
        }

        $(function () {
            var objEditor = $('#editor');
            objEditor.css('height', '400px');
            objEditor.css('width', '100%');

            var ue = UE.getEditor('editor');

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function () {
                readURL(this);
            });

            setDeleteSpec();

            var objForm = $("#form-product");

            objForm.validate({
                rules:{
                    name:{
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                    price: {
                        required: true,
                        number: true,
                        fractionLimit: 2
                    },
                    deliver_cost: {
                        required: true
                    },
                    remain: {
                        required: true
                    },
                    gb_count: {
                        required: true
                    },
                    gb_price: {
                        required: true
                    },
                    gb_timeout: {
                        required: true
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
            });

            objForm.submit(function (e) {
                e.preventDefault();

                if (uploader.getFiles().length <= 0) {
                    alert('请添加图片');
                    return false;
                }

                var sendData = new FormData();
                var formData = $(this).serializeArray();

                $.each(formData, function (i, field) {
                    sendData.append(field.name, field.value);
                });

                //
                // 缩略图
                //
                var objImg = $('#imgInp')[0];
                if (objImg && objImg.files[0])
                {
                    sendData.append('thumbimage', objImg.files[0]);
                }

                var content = UE.getEditor('editor').getContent();
                sendData.append('rtf_content', content);

                // 提交
                $.ajax({
                    type: 'POST',
                    url: '{{url("/product")}}',
                    data: sendData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        // 上传图片
                        uploader.options.formData.product_id = data.product_id;
                        uploader.upload();
                    },
                    error: function (data) {
                        enableSubmit('butSubmit', true);
                        $('#butSubmit span').text('保存并提交');
                        console.log(data);
                    }
                });

                enableSubmit('butSubmit', false);
                $('#butSubmit span').text('正在提交...');

                return false;
            });

            $('#butSubmit').click(function(e) {
                objForm.submit();
            });
        });

        (function ($) {
            // 当domReady的时候开始初始化
            $(function () {
                var $wrap = $('.uploader-list-container'),

                // 图片容器
                $queue = $('<ul class="filelist"></ul>').appendTo($wrap.find('.queueList')),

                // 状态栏，包括进度和控制按钮
                $statusBar = $wrap.find('.statusBar'),

                // 文件总体选择信息。
                $info = $statusBar.find('.info'),

                // 没选择文件之前的内容。
                $placeHolder = $wrap.find('.placeholder'),

                $progress = $statusBar.find('.progress').hide(),

                // 添加的文件数量
                fileCount = 0,

                // 添加的文件总大小
                fileSize = 0,

                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

                // 缩略图大小
                thumbnailWidth = 110 * ratio,
                thumbnailHeight = 110 * ratio,

                // 可能有pedding, ready, uploading, confirm, done.
                state = 'pedding',

                // 所有文件的进度信息，key为file id
                percentages = {},
                // 判断浏览器是否支持图片的base64
                isSupportBase64 = (function () {
                    var data = new Image();
                    var support = true;
                    data.onload = data.onerror = function () {
                        if (this.width != 1 || this.height != 1) {
                            support = false;
                        }
                    }
                    data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                    return support;
                })(),

                // 检测是否已经安装flash，检测flash的版本
                flashVersion = (function () {
                    var version;

                    try {
                        version = navigator.plugins['Shockwave Flash'];
                        version = version.description;
                    } catch (ex) {
                        try {
                            version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                                    .GetVariable('$version');
                        } catch (ex2) {
                            version = '0.0';
                        }
                    }
                    version = version.match(/\d+/g);
                    return parseFloat(version[0] + '.' + version[1], 10);
                })(),

                supportTransition = (function () {
                    var s = document.createElement('p').style,
                            r = 'transition' in s ||
                                    'WebkitTransition' in s ||
                                    'MozTransition' in s ||
                                    'msTransition' in s ||
                                    'OTransition' in s;
                    s = null;
                    return r;
                })();

                if (!WebUploader.Uploader.support('flash') && WebUploader.browser.ie) {

                    // flash 安装了但是版本过低。
                    if (flashVersion) {
                        (function (container) {
                            window['expressinstallcallback'] = function (state) {
                                switch (state) {
                                    case 'Download.Cancelled':
                                        alert('您取消了更新！')
                                        break;

                                    case 'Download.Failed':
                                        alert('安装失败')
                                        break;

                                    default:
                                        alert('安装已成功，请刷新！');
                                        break;
                                }
                                delete window['expressinstallcallback'];
                            };

                            var swf = 'expressInstall.swf';
                            // insert flash object
                            var html = '<object type="application/' +
                                    'x-shockwave-flash" data="' + swf + '" ';

                            if (WebUploader.browser.ie) {
                                html += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                            }

                            html += 'width="100%" height="100%" style="outline:0">' +
                                    '<param name="movie" value="' + swf + '" />' +
                                    '<param name="wmode" value="transparent" />' +
                                    '<param name="allowscriptaccess" value="always" />' +
                                    '</object>';

                            container.html(html);

                        })($wrap);

                        // 压根就没有安转。
                    } else {
                        $wrap.html('<a href="http://www.adobe.com/go/getflashplayer" target="_blank" border="0"><img alt="get flash player" src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" /></a>');
                    }

                    return;
                } else if (!WebUploader.Uploader.support()) {
                    alert('Web Uploader 不支持您的浏览器！');
                    return;
                }

                // 实例化
                uploader = WebUploader.create({
                    pick: {
                        id: '#filePicker-2',
                        label: '点击选择图片'
                    },
                    formData: {
                        _token:'{{ csrf_token() }}'
                    },
                    dnd: '#dndArea',
                    paste: '#uploader',
                    swf: 'lib/webuploader/0.1.5/Uploader.swf',
                    chunked: false,
                    chunkSize: 512 * 1024,
                    method: 'POST',
                    server: '{{url("/product/uploadImage")}}',
                    // runtimeOrder: 'flash',

                    // accept: {
                    //     title: 'Images',
                    //     extensions: 'gif,jpg,jpeg,bmp,png',
                    //     mimeTypes: 'image/*'
                    // },

                    // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
                    disableGlobalDnd: true,
                    fileNumLimit: 300,
                    fileSizeLimit: 200 * 1024 * 1024,    // 200 M
                    fileSingleSizeLimit: 50 * 1024 * 1024,    // 50 M
                    threads: 1,  // 上传并发数。 允许同时最大上传进程数，为了保证问价上传顺序
                    compress: false
                });

                // 拖拽时不接受 js, txt 文件。
                uploader.on('dndAccept', function (items) {
                    var denied = false,
                            len = items.length,
                            i = 0,
                    // 修改js类型
                            unAllowed = 'text/plain;application/javascript ';

                    for (; i < len; i++) {
                        // 如果在列表里面
                        if (~unAllowed.indexOf(items[i].type)) {
                            denied = true;
                            break;
                        }
                    }

                    return !denied;
                });

                uploader.on('dialogOpen', function () {
                    console.log('here');
                });

                // uploader.on('filesQueued', function() {
                //     uploader.sort(function( a, b ) {
                //         if ( a.name < b.name )
                //           return -1;
                //         if ( a.name > b.name )
                //           return 1;
                //         return 0;
                //     });
                // });

                // 添加“添加文件”的按钮，
                uploader.addButton({
                    id: '#filePicker2',
                    label: '继续添加'
                });

                var strImagePaths = [];
                function addProductImages(imgIndex) {
                    getFileObject(strImagePaths[imgIndex], function (fileObject) {
                        uploader.addFile(fileObject);

                        // 继续添加
                        if (strImagePaths.length > imgIndex + 1) {
                            addProductImages(imgIndex + 1);
                        }
                    });
                }

                uploader.on('ready', function () {
                    window.uploader = uploader;

                    // 读取图片文件
                    @if (!empty($product))
                        @foreach ($product->images as $img)
                            strImagePaths.push('{{$img->getImageUrl()}}');
                        @endforeach

                        addProductImages(0);
                    @endif
                });

                // 当有文件添加进来时执行，负责view的创建
                function addFile(file) {
                    var $li = $('<li id="' + file.id + '">' +
                                    '<p class="title">' + file.name + '</p>' +
                                    '<p class="imgWrap"></p>' +
                                    '<p class="progress"><span></span></p>' +
                                    '</li>'),

                            $btns = $('<div class="file-panel">' +
                                    '<span class="cancel">删除</span>' +
                                    '<span class="rotateRight">向右旋转</span>' +
                                    '<span class="rotateLeft">向左旋转</span></div>').appendTo($li),
                            $prgress = $li.find('p.progress span'),
                            $wrap = $li.find('p.imgWrap'),
                            $info = $('<p class="error"></p>'),

                            showError = function (code) {
                                switch (code) {
                                    case 'exceed_size':
                                        text = '文件大小超出';
                                        break;

                                    case 'interrupt':
                                        text = '上传暂停';
                                        break;

                                    default:
                                        text = '上传失败，请重试';
                                        break;
                                }

                                $info.text(text).appendTo($li);
                            };

                    if (file.getStatus() === 'invalid') {
                        showError(file.statusText);
                    } else {
                        // @todo lazyload
                        $wrap.text('预览中');
                        uploader.makeThumb(file, function (error, src) {
                            var img;

                            if (error) {
                                $wrap.text('不能预览');
                                return;
                            }

                            if (isSupportBase64) {
                                img = $('<img src="' + src + '">');
                                $wrap.empty().append(img);
                            } else {
                                $.ajax('lib/webuploader/0.1.5/server/preview.php', {
                                    method: 'POST',
                                    data: src,
                                    dataType: 'json'
                                }).done(function (response) {
                                    if (response.result) {
                                        img = $('<img src="' + response.result + '">');
                                        $wrap.empty().append(img);
                                    } else {
                                        $wrap.text("预览出错");
                                    }
                                });
                            }
                        }, thumbnailWidth, thumbnailHeight);

                        percentages[file.id] = [file.size, 0];
                        file.rotation = 0;
                    }

                    file.on('statuschange', function (cur, prev) {
                        if (prev === 'progress') {
                            $prgress.hide().width(0);
                        } else if (prev === 'queued') {
                            $li.off('mouseenter mouseleave');
                            $btns.remove();
                        }

                        // 成功
                        if (cur === 'error' || cur === 'invalid') {
                            console.log(file.statusText);
                            showError(file.statusText);
                            percentages[file.id][1] = 1;
                        } else if (cur === 'interrupt') {
                            showError('interrupt');
                        } else if (cur === 'queued') {
                            percentages[file.id][1] = 0;
                        } else if (cur === 'progress') {
                            $info.remove();
                            $prgress.css('display', 'block');
                        } else if (cur === 'complete') {
                            $li.append('<span class="success"></span>');
                        }

                        $li.removeClass('state-' + prev).addClass('state-' + cur);
                    });

                    $li.on('mouseenter', function () {
                        $btns.stop().animate({height: 30});
                    });

                    $li.on('mouseleave', function () {
                        $btns.stop().animate({height: 0});
                    });

                    $btns.on('click', 'span', function () {
                        var index = $(this).index(),
                                deg;

                        switch (index) {
                            case 0:
                                uploader.removeFile(file);
                                return;

                            case 1:
                                file.rotation += 90;
                                break;

                            case 2:
                                file.rotation -= 90;
                                break;
                        }

                        if (supportTransition) {
                            deg = 'rotate(' + file.rotation + 'deg)';
                            $wrap.css({
                                '-webkit-transform': deg,
                                '-mos-transform': deg,
                                '-o-transform': deg,
                                'transform': deg
                            });
                        } else {
                            $wrap.css('filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation=' + (~~((file.rotation / 90) % 4 + 4) % 4) + ')');
                            // use jquery animate to rotation
                            // $({
                            //     rotation: rotation
                            // }).animate({
                            //     rotation: file.rotation
                            // }, {
                            //     easing: 'linear',
                            //     step: function( now ) {
                            //         now = now * Math.PI / 180;

                            //         var cos = Math.cos( now ),
                            //             sin = Math.sin( now );

                            //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                            //     }
                            // });
                        }


                    });

                    $li.appendTo($queue);
                }

                // 负责view的销毁
                function removeFile(file) {
                    var $li = $('#' + file.id);

                    delete percentages[file.id];
                    updateTotalProgress();
                    $li.off().find('.file-panel').off().end().remove();
                }

                function updateTotalProgress() {
                    var loaded = 0,
                            total = 0,
                            spans = $progress.children(),
                            percent;

                    $.each(percentages, function (k, v) {
                        total += v[0];
                        loaded += v[0] * v[1];
                    });

                    percent = total ? loaded / total : 0;


                    spans.eq(0).text(Math.round(percent * 100) + '%');
                    spans.eq(1).css('width', Math.round(percent * 100) + '%');
                    updateStatus();
                }

                function updateStatus() {
                    var text = '', stats;

                    if (state === 'ready') {
                        text = '选中' + fileCount + '张图片，共' +
                                WebUploader.formatSize(fileSize) + '。';
                    } else if (state === 'confirm') {
                        stats = uploader.getStats();
                        if (stats.uploadFailNum) {
                            text = '已成功上传' + stats.successNum + '张照片至XX相册，' +
                                    stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                        }

                    } else {
                        stats = uploader.getStats();
                        text = '共' + fileCount + '张（' +
                                WebUploader.formatSize(fileSize) +
                                '），已上传' + stats.successNum + '张';

                        if (stats.uploadFailNum) {
                            text += '，失败' + stats.uploadFailNum + '张';
                        }
                    }

                    $info.html(text);
                }

                function setState(val) {
                    var file, stats;

                    if (val === state) {
                        return;
                    }

                    state = val;

                    switch (state) {
                        case 'pedding':
                            $placeHolder.removeClass('element-invisible');
                            $queue.hide();
                            $statusBar.addClass('element-invisible');
                            uploader.refresh();
                            break;

                        case 'ready':
                            $placeHolder.addClass('element-invisible');
                            $('#filePicker2').removeClass('element-invisible');
                            $queue.show();
                            $statusBar.removeClass('element-invisible');
                            uploader.refresh();
                            break;

                        case 'uploading':
                            $('#filePicker2').addClass('element-invisible');
                            $progress.show();
                            break;

                        case 'paused':
                            $progress.show();
                            break;

                        case 'confirm':
                            $progress.hide();
                            $('#filePicker2').removeClass('element-invisible');

                            stats = uploader.getStats();
                            if (stats.successNum && !stats.uploadFailNum) {
                                setState('finish');
                                return;
                            }
                            break;
                        case 'finish':
                            stats = uploader.getStats();
                            if (stats.successNum) {
                                // 恢复提交按钮
                                alert('提交成功！');

                                location.href = '{{url("/products")}}';
                            }
                            else {
                                // 没有成功的图片，重设
                                state = 'done';
                                location.reload();
                            }
                            break;
                    }

                    updateStatus();
                }

                uploader.onUploadProgress = function (file, percentage) {
                    var $li = $('#' + file.id),
                            $percent = $li.find('.progress span');

                    $percent.css('width', percentage * 100 + '%');
                    percentages[file.id][1] = percentage;
                    updateTotalProgress();
                };

                uploader.onFileQueued = function (file) {
                    fileCount++;
                    fileSize += file.size;

                    if (fileCount === 1) {
                        $placeHolder.addClass('element-invisible');
                        $statusBar.show();
                    }

                    addFile(file);
                    setState('ready');
                    updateTotalProgress();
                };

                uploader.onFileDequeued = function (file) {
                    fileCount--;
                    fileSize -= file.size;

                    if (!fileCount) {
                        setState('pedding');
                    }

                    removeFile(file);
                    updateTotalProgress();

                };

                uploader.on('all', function (type) {
                    var stats;
                    switch (type) {
                        case 'uploadFinished':
                            setState('confirm');
                            break;

                        case 'startUpload':
                            setState('uploading');
                            break;

                        case 'stopUpload':
                            setState('paused');
                            break;

                    }
                });

                uploader.onError = function (code) {
                    alert('Eroor: ' + code);
                };

                $info.on('click', '.retry', function () {
                    uploader.retry();
                });

                $info.on('click', '.ignore', function () {
                    alert('todo');
                });

                updateTotalProgress();
            });

        })(jQuery);

        $('#btn-rule-add').on('click', function (e) {
            e.preventDefault();

            console.log('adding rule');
            var rule = $('#rule-name').val();
            if (rule.length <= 0) {
                return;
            }

            // 提交
            $.ajax({
                type: 'POST',
                url: '{{url("/rule")}}',
                data: {
                    'name': rule,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    enableSubmit('btn-rule-add', true);

                    // 添加到主页面
                    $('.prod-spec').append('<label>' +
                        '<input type="checkbox" value="1" name="spec' + data.rule + '" checked /> ' +
                        rule +
                        '<a data-spec="' + data.rule + '"><i class="Hui-iconfont">&#xe6a6;</i></a>' +
                        '</label>');

                    // 清空规则输入
                    $('#rule-name').val('');

                    setDeleteSpec();
                },
                error: function (data) {
                    enableSubmit('btn-rule-add', true);
                    console.log(data);
                }
            });

            enableSubmit('btn-rule-add', false);
        });

        /**
         * 使用/禁用按钮
         * @param strId
         */
        function enableSubmit(strId, enable) {
            var objSubmit = $('#' + strId);
            if (enable) {
                objSubmit.removeClass('disabled');
                objSubmit.removeAttr('disabled');
            }
            else {
                objSubmit.addClass('disabled');
                objSubmit.attr('disabled');
            }
        }

        UE.getEditor('editor').ready(function() {
            @if(isset($product))
                var content = $('<textarea />').html('{{$product->rtf_content}}').text();
                UE.getEditor('editor').setContent(content);
            @endif
        });
    </script>

@endsection