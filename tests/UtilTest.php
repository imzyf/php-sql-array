<?php

declare(strict_types=1);

include '../vendor/autoload.php';

use Yifans\SqlArray\Util as Util;

$arr1 = [1, 2, 3, 4];
$arr2 = [1 => [1, 2, 3, 4], 2, 3 => [1, 2, 3], 4];
$arr3 = [1 => [1, 2, 3 => [1, 3], 4], 2, 3, 4];

var_dump(Util::depth($arr1));
var_dump(Util::depth($arr2));
var_dump(Util::depth($arr3));

var_dump(Util::isMultiple($arr1));
var_dump(Util::isMultiple($arr2));
