<?php

$stacks     = debug_backtrace();
foreach($stacks as $_stack) {
    if (!isset($_stack['file'])) $_stack['file'] = '[PHP Kernel]';
    if (!isset($_stack['line'])) $_stack['line'] = '';
    Mage::log($_stack["file"].':'.$_stack["function"], null, 'backtrace.log');
}