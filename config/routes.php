<?php
$routes['default_namespace'] = 'client';
$routes['default_controller'] = 'home';
/*
 *  Đường dẫn ảo => Đường dẫn thật
 * */

// Client
$routes['trang-chu'] = 'client/home';
$routes['on-tap/trang-(\d+).html'] = 'client/ontap/index/$1';
$routes['on-tap/tim-kiem/trang-(\d+).html'] = 'client/ontap/search/$1';
//$routes['on-tap/tim-kiem'] = 'client/ontap/search/1';
$routes['on-tap'] = 'client/ontap/index/1';

// Admin
// ...