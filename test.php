<?php


function a()
{
    echo 111111;
    \Swoole\Timer::after(2000, function() {
        echo "start ....\n";
        echo date('Y-m-d H:i:s');
        echo PHP_EOL;
        a();
        sleep(1);
    });
}

a();
