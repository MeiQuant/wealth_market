### 部署文档
1 将 public/common.php 中的 DEBUG 变量更改为 false, 否则有些功能是错误的

2 安装php的yaf扩展

3 安装php的mc和redis扩展, 并启动redis-server

4 到 conf/application.ini中更改 database, upload, mc, redis的配置选项

5 在网站根目录下执行 composer install (切记不要执行 composer update, 因为最新的包不太兼容php的版本)

6 代码中没有对sql的`delete`, `admin`等敏感词进行过滤, 请运维自己过滤敏感词汇

7 cron 每天早上0点1分执行 

0 1 * * *  /usr/bin/php /usr/local/var/www/wealth_market/public/cli.php "request_uri=/publish/run"  >> /tmp/cron.d.log &





### 其他

(一)打印sql log日志
@1 修改Illuminate\Database\Connection的$loggingQueries = true
@2 print_r(DB::getQueryLog());

