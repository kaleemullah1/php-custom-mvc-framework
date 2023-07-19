<?php
namespace App\Bootstrap;
// load autoload files
use App\Classes\Request;

require_once 'autoload.php';

echo Request::send();

?>