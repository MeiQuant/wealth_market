### 部署文档
1 将 public/common.php 中的 DEBUG 变量更改为 false, 否则的话所有的接口都不会走缓存, 包括微信接口， 并且有些功能不能用

2 安装php的yaf扩展

3 在网站根目录下执行 composer install (切记不要执行 composer update, 因为最新的包不太兼容php的版本)

4 代码中没有对sql的`delete`, `admin`等敏感词进行过滤, 请运维自己过滤敏感词汇








### 其他

(一)打印sql log日志
@1 修改Illuminate\Database\Connection的$loggingQueries = true
@2 print_r(DB::getQueryLog());

