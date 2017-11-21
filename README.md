(一)打印sql log日志
@1 修改Illuminate\Database\Connection的$loggingQueries = true
@2 print_r(DB::getQueryLog());



(二)问题1:
  代码上线的时候, 所有server的update_time不可能同时更新就会造成误判成server死掉
  
  
(三)关闭yaf命名空间

(四)入口程序采用supervisor程序启动, 可以有效的检测进程挂掉重启, 折腾了一下午, 附上安装步骤和遇到的坑

1. 安装方式

a. 官方网址为 http://supervisord.org/installing.html， 里面提供了3种安装方式, 我采用的是第三种安装方式, 可能前两种比较简单, 但是测试机上都没安装成功, 缺少依赖的包, 就直接干脆粗暴的采取了第三种安装方式,分别下载三个安装包, 分别安装

b. * setuptools (latest) from http://pypi.python.org/pypi/setuptools.
```
/usr/local/sinasrv2/bin/python2.7 setup.py install
```
* setuptools (latest) from http://www.plope.com/software/meld3/.
```
/usr/local/sinasrv2/bin/python2.7 setup.py install
```  
ps : meld3这个官方网站挂出的地址可能打不开, 可以自行到python package网站上自行下载  

* 下载supervisor安装包
https://pypi.python.org/pypi/supervisor  
```
/usr/local/sinasrv2/bin/python2.7 setup.py install
```  
ps : 测试机上默认的python为python2.6, 建议采用 >= python2.7版本的, 要不然会有想不到的坑  

2. 配置文件  
安装完之后你会发现找不到配置文件, 需要自行创建  
```
mkdir /etc/supervisor
echo_supervisord_conf > /etc/supervisor/supervisord.conf
```  
3. 配置文件说明
```
[unix_http_server]
file=/tmp/supervisor.sock   ;UNIX socket 文件，supervisorctl 会使用
;chmod=0700                 ;socket文件的mode，默认是0700
;chown=nobody:nogroup       ;socket文件的owner，格式：uid:gid

;[inet_http_server]         ;HTTP服务器，提供web管理界面
;port=127.0.0.1:9001        ;Web管理后台运行的IP和端口，如果开放到公网，需要注意安全性
;username=user              ;登录管理后台的用户名
;password=123               ;登录管理后台的密码

[supervisord]
logfile=/tmp/supervisord.log ;日志文件，默认是 $CWD/supervisord.log
logfile_maxbytes=50MB        ;日志文件大小，超出会rotate，默认 50MB，如果设成0，表示不限制大小
logfile_backups=10           ;日志文件保留备份数量默认10，设为0表示不备份
loglevel=info                ;日志级别，默认info，其它: debug,warn,trace
pidfile=/tmp/supervisord.pid ;pid 文件
nodaemon=false               ;是否在前台启动，默认是false，即以 daemon 的方式启动
minfds=1024                  ;可以打开的文件描述符的最小值，默认 1024
minprocs=200                 ;可以打开的进程数的最小值，默认 200

[supervisorctl]
serverurl=unix:///tmp/supervisor.sock ;通过UNIX socket连接supervisord，路径与unix_http_server部分的file一致
;serverurl=http://127.0.0.1:9001 ; 通过HTTP的方式连接supervisord

; [program:xx]是被管理的进程配置参数，xx是进程的名称
[program:xx]
command=/opt/apache-tomcat-8.0.35/bin/catalina.sh run  ; 程序启动命令
autostart=true       ; 在supervisord启动的时候也自动启动
startsecs=10         ; 启动10秒后没有异常退出，就表示进程正常启动了，默认为1秒
autorestart=true     ; 程序退出后自动重启,可选值：[unexpected,true,false]，默认为unexpected，表示进程意外杀死后才重启
startretries=3       ; 启动失败自动重试次数，默认是3
user=tomcat          ; 用哪个用户启动进程，默认是root
priority=999         ; 进程启动优先级，默认999，值小的优先启动
redirect_stderr=true ; 把stderr重定向到stdout，默认false
stdout_logfile_maxbytes=20MB  ; stdout 日志文件大小，默认50MB
stdout_logfile_backups = 20   ; stdout 日志文件备份数，默认是10
; stdout 日志文件，需要注意当指定目录不存在时无法正常启动，所以需要手动创建目录（supervisord 会自动创建日志文件）
stdout_logfile=/opt/apache-tomcat-8.0.35/logs/catalina.out
stopasgroup=false     ;默认为false,进程被杀死时，是否向这个进程组发送stop信号，包括子进程
killasgroup=false     ;默认为false，向进程组发送kill信号，包括子进程

;包含其它配置文件
[include]
files = relative/directory/*.ini    ;可以指定一个或多个以.ini结束的配置文件
```

4. cron_monitor配置的一个例子
```
[program:cron_monitor]
command=/usr/local/sinasrv2/bin/php /data1/www/htdocs/cron_monitor/public/cli.php "request_uri=/daemon/process"
stdout_logfile=/tmp/page_cron_monitor.log
autostart=true
autorestart=true
user=www
startsecs=10
priority=1
stopasgroup=true
killasgroup=true
redirect_stderr=true
```  
5. 启动supervisor服务
```
supervisord -c /etc/supervisor/supervisord.conf
```

6. 一些常用的命令
```
supervisorctl status
supervisorctl stop name/all
supervisorctl start name/all
supervisorctl restart name/all
supervisorctl reread
supervisorctl update
```

7. 其他比如supervisor开机启动啥的自行处理
  
