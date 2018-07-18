# a-Forum-in-Laravel

使用 Laravel 5.5 构建的论坛系统

## 安装说明：

1、下载程序

git clone https://github.com/bai615/a-Forum-in-Laravel.git

cd a-Forum-in-Laravel


2、安装依赖库文件

composer install -vvv 或者 composer update -vvv

3、设置配置文件

cp .env.example .env

vim .env

修改数据库配置项
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database name
DB_USERNAME=user name
DB_PASSWORD=password
```

4、更新数据库

php artisan migrate

5、运行项目
php artisan serve
