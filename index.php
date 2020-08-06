<?php

require __DIR__ . '/vendor/autoload.php';

use App\Main\Adapters\STDIOAdapter;

(new STDIOAdapter())->run();
