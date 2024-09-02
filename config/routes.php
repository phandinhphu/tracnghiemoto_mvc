<?php
$routes['default_namespace'] = 'client';
$routes['default_controller'] = 'home';
/*
 *  Đường dẫn ảo => Đường dẫn thật
 * */

// Client
$routes['dang-nhap'] = 'client/auth/login';
$routes['dang-ky'] = 'client/auth/register';
$routes['trang-chu'] = 'client/home';
$routes['thi-thu'] = 'client/thithu';
$routes['on-tap/trang-(\d+).html'] = 'client/ontap/index/$1';
$routes['on-tap/tim-kiem/trang-(\d+).html'] = 'client/ontap/search/$1';
$routes['on-tap'] = 'client/ontap/index/1';

// Admin
// ...