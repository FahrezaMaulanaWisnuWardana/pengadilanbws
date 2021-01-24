<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['beranda'] = 'dashboard';
$route['ruangan'] = 'room';
$route['ruangan/tambah'] = 'room/add';
$route['ruangan/hapus'] = 'room/delete';
$route['ruangan/edit/(:num)'] = 'room/update/$1';
$route['ruangan/pengguna'] = 'room/user';
$route['ruangan/pengguna/tambah'] = 'room/add_user';
$route['ruangan/pengguna/simpan'] = 'room/save_user';
$route['pengguna']='user';
$route['pengguna/tambah']='user/add';
$route['pengguna/hapus']='user/delete';
$route['pengguna/edit/(:num)'] = 'user/update/$1';
$route['pengguna/edit/password/(:num)'] = 'user/upd_password/$1';
$route['hak-akses'] = 'role';
$route['hak-akses/tambah'] = 'role/add';
$route['hak-akses/hapus'] = 'role/delete';
$route['hak-akses/edit/(:num)'] = 'role/update/$1';
$route['tugas'] = 'task';
$route['tugas/tambah'] = 'task/add';
$route['tugas/simpan'] = 'task/save';
$route['tugas/hapus'] = 'task/delete';
$route['tugas/edit/(:num)'] = 'task/update/$1';