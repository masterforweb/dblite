<?php

require 'db_lite.php';


db_config('cheaper', 'root', 'KXTvBqJFPhLGfquY', 'mysql');
$result = db_get('SELECT firstname,lastname,email FROM users');

print_r($result);

