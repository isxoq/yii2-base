<?php
/*
Project Name: taxi.loc
File Name: server.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/22/2021 9:27 AM
*/


$this->registerJs(
    <<<JS
         var conn = new WebSocket('ws://localhost:81');
            conn.onmessage = function(e) {
                console.log('Response:' + e.data);
            };
            conn.onopen = function(e) {
                console.log('ping');
                conn.send('ping');
            };
JS

);