<?php
$routes['default_namespace'] = 'client';
$routes['default_controller'] = 'home';
/*
 *  Đường dẫn ảo => Đường dẫn thật
 * */

// Client
$routes['dang-nhap'] = 'client/auth/login';
$routes['dang-xuat'] = 'client/auth/logout';
$routes['dang-ky'] = 'client/auth/register';
$routes['trang-chu'] = 'client/home';
$routes['thi-thu'] = 'client/thithu';
$routes['lich-su/cau-hoi/trang-(\d+).html'] = 'client/history/questions/$1';
$routes['lich-su/cau-hoi'] = 'client/history/questions';
$routes['lich-su/bai-thi/trang-(\d+).html'] = 'client/history/exams/$1';
$routes['lich-su/bai-thi'] = 'client/history/exams';
$routes['lich-su'] = 'client/history';
$routes['on-tap/trang-(\d+).html'] = 'client/ontap/index/$1';
$routes['on-tap/tim-kiem/trang-(\d+).html'] = 'client/ontap/search/$1';
$routes['on-tap'] = 'client/ontap/index/1';
$routes['ho-so/cap-nhat'] = 'client/profile/updateInfo';
$routes['ho-so'] = 'client/profile/userProfile';
$routes['doi-mat-khau/cap-nhat'] = 'client/profile/updatePassword';
$routes['doi-mat-khau'] = 'client/profile/changePassword';

// Admin
// ...