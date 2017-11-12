# lumen-api-qpay


## USEFUL LINK

读文档很重要，请先仔细读读文档 laravel, dingo/api，jwt，fractal 的文档。

- dingo/api [https://github.com/dingo/api](https://github.com/dingo/api)
- dingo api 中文文档 [dingo-api-wiki-zh](https://github.com/liyu001989/dingo-api-wiki-zh)
- jwt(json-web-token) [https://github.com/tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
- transformer [fractal](http://fractal.thephpleague.com/)
- apidoc 生成在线文档 [apidocjs](http://apidocjs.com/)
- rest api 参考规范 [jsonapi.org](http://jsonapi.org/format/)
- api 调试工具 [postman](https://www.getpostman.com/)
- 有用的文章 [http://oomusou.io/laravel/laravel-architecture](http://oomusou.io/laravel/laravel-architecture/)
- php lint [phplint](https://github.com/overtrue/phplint)

## 关于采集
    现在采集不需要去识别验证码，


## USAGE

```

环境要求：　linux , php5.6.4+, lumen5.4+

$ composer install
$ 设置 `storage` 目录必须让服务器有写入权限。
在storage/app/下创建cache目录
$ cp .env.example .env
$ vim .env
    DB_*
        填写数据库相关配置 your database configuration
    JWT_SECRET
        php artisan jwt:secret
    APP_KEY
        lumen 取消了key:generate 所以随便找个地方生成一下吧
        md5(uniqid())，str_random(32) 之类的，或者用jwt:secret生成两个copy一下
    QPAY_USERNAME
        支付通账号        
    QPAY_PASSWORD
       支付通密码

导入数据库
$ php artisan migrate
创建管理员
$ php artisan create:user
采集数据
$ php artisan collect:agent  ( 这里可以用linux 下的contab来做定时采集 )     


路由文件在　routes/api/vi.php文件中
控制器在　app/Http/Controllers/Api/V1/目录下

采集控制台在　app/console/Commands/CollectAgent.php 文件中


头信息中可以增加 Accept:application/vnd.lumen.v1+json 切换v1和v2版本

api文档在public/apidoc里面有一份

生成文档: apidoc -i App/Http/Controllers/Api/V1/ -o public/apidoc/

```


