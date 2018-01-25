食品农产品交易后台服务&管理页面
======

> Food purchase platform, Backend & admin pages for [Wechat Mini-Program](https://github.com/highjump0615/Duck_Wechat_MiniProgram)

## Overview

### 1. 主要功能
- 订单管理  
订单列表、下单（微信支付）、推送（发货、拼团成功、拼团失败）  
- 宣传管理  
活动列表  
- 商品管理  
产品分类：添加、删除、修改、调整顺序  
产品列表：添加、删除、修改  
产品规格：添加、删除
- 管理员管理  
管理员列表：添加、删除、修改、设置角色  
- 门店管理  
门店列表：添加、删除、修改  
- 数据统计  
自定义查询  

### 2. 技术内容
#### 2.1 Admin & RESTful Api (Laravel PHP Framework v5.3.31)
- web.php 与 api.php 分别维护管理页面与API的路由  
通过auth Middleware与Auth实现认证用户
- 通过migration创建、维护数据库  
- 采用Task Scheduler实现cron jobs, 充分利用框架本身的优势  
自定义artisan的Command
- 自定义helper方法提高代码质量和方便  
```getCurDateString()``` 当前日期转换为```yyyy-MM-dd```  
```getStringFromDate()``` 指定时间转换为```yyyy-MM-dd```  
```getStringFromDateTime()``` 指定时间转换为```yyyy-MM-dd hh:mm:ss```  
```getEmptyString()``` 参数不管是否null, 返回string  
```intToString()``` 生成指定位数的编号（转string)
##### 2.1.1 Third-Party Libraries
- [微信支付SDK PHP v3.0](https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=11_1)  
```WxPayApi::unifiedOrder()``` 支付与微信订单的生成  
```WxPayApi::refund()``` 退款
- [Guzzle Http调用HTTP接口](https://github.com/guzzle/guzzle)  
https://api.weixin.qq.com/sns/jscode2session 获取openid  
https://api.weixin.qq.com/cgi-bin/token 获取accessToken  
https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send 发送推送消息  

#### 2.2 Admin前端页面
基于[HUI Admin v3.1](http://www.h-ui.net/H-ui.admin.shtml)模板实现页面设计
##### 2.2.1 代码技巧
- jQuery 获取Url的GET参数列表  
```
var paramGet = $.urlGet();
```
##### 2.2.2 Third-Party Libraries
- [jQuery v1.9.1](https://github.com/jquery/jquery)  
- [jQuery Validation 插件 v1.14.0](https://github.com/jquery-validation/jquery-validation)  
各种表单提交时验证
- [jQuery chosen选择框插件 v1.7.0](https://github.com/harvesthq/chosen)  
自定义查询页面：门店多选框
- [jQuery DataTables 插件 v1.10.0](https://github.com/DataTables/DataTables)  
数据列表
- [My97DatePicker日期选择插件 v4.8](http://www.my97.net/)  
列表页面：输入筛选时间范围
- [jQuery twbsPagination分页插件 v1.4.1](https://github.com/esimakin/twbs-pagination)  
列表页面：分页显示
- [UEditor编辑器 v1.4.3](https://github.com/fex-team/ueditor)  
产品编辑页面：富文本编辑
- [WebUploader文件上传组件 v0.1.5](https://github.com/fex-team/webuploader/)  
产品编辑页面：图片上传
- [zTree jQuery树插件 v3.5.29](https://github.com/zTree/zTree_v3)  
产品分类与产品列表页面
- [Web弹窗 Layer v3.0](http://layer.layui.com/) 
  
## Need to Improve  
- 支付SDK使用Laravel插件
