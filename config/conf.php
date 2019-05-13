<?php

define('TEMPLATES_DIR', '../views/');
define('LAYOUTS_DIR', 'layouts/');
define ('IMG_DIR', 'images/');
define ('TMB_DIR', 'thumbnails/');
define ('LOG_DIR', '../logs/');

define('TMB_SIZE', 200);

set_time_limit(10);

define('MSG_IMG_UPLOAD_SUCCESS', 0);
define('ERR_IMG_LOADING', 1);
define('ERR_UNSUPPORTED_IMG', 2);
define('ERR_IMG_TOO_LARGE', 3);
define('ERR_FILE_UPLOAD_FAILED', 4);