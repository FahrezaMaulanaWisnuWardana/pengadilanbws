<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['beranda'] = 'dashboard';
$route['beranda/tugas-ruangan'] = 'dashboard/task_room';
$route['beranda/tugas/(:num)/(:num)'] = 'dashboard/task/$1/$2';
$route['beranda/tugas-pimpinan/(:num)'] = 'dashboard/task_leader/$1';
$route['beranda/simpan-tugas'] = 'dashboard/save';
$route['beranda/cek-tugas'] = 'dashboard/cek';
$route['beranda/cek-gambar'] = 'dashboard/cek_gambar';
$route['beranda/edit-tugas'] = 'dashboard/update';
$route['beranda/update-nilai'] = 'dashboard/update_score';

$route['laporan'] = 'report';
$route['laporan/detail/(:num)'] = 'report/detail/$1';
$route['laporan/cetak'] = 'report/cetak';

$route['permintaan'] = 'request';
$route['permintaan/simpan-permintaan'] = 'request/save';
$route['permintaan/cek-permintaan'] = 'request/cek_request';
$route['permintaan/update-permintaan'] = 'request/update_request';

$route['ruangan'] = 'room';
$route['ruangan/tambah'] = 'room/add';
$route['ruangan/hapus'] = 'room/delete';
$route['ruangan/edit/(:num)'] = 'room/update/$1';
$route['ruangan/pengguna'] = 'room/user';
$route['ruangan/pengguna/(:num)'] = 'room/user/$1';
$route['ruangan/pengguna/tambah/(:num)'] = 'room/add_user/$1';
$route['ruangan/pengguna/simpan'] = 'room/save_user';
$route['ruangan/pengguna/edit/(:num)'] = 'room/update_user/$1';
$route['ruangan/pengguna/hapus'] = 'room/delete_user';
$route['ruangan/validasi-akun'] = 'room/cek_room_user';

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
$route['tugas/ruangan'] = 'task/room';
$route['tugas/ruangan/(:num)'] = 'task/room/$1';

$route['keluar'] = 'login/logout';