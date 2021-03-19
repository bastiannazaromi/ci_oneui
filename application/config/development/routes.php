<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller']                            = 'login';
$route['404_override']                                  = '';
$route['translate_uri_dashes']                          = FALSE;

$route['spreadsheet']                                   = 'PhpspreadsheetController';
$route['spreadsheet/import']                            = 'PhpspreadsheetController/import';
$route['spreadsheet/export']                            = 'PhpspreadsheetController/export';

$route['logout']                                        = 'login/logout';
$route['suspicious']                                    = 'login/suspicious';

// admin
$route['admin/profile']                                 = 'admin';
$route['admin/profile/(:any)']                          = 'admin';

$route['admin/fakultas']                                = 'admin/ref_fakultas';
$route['admin/fakultas/(:any)']                         = 'admin/ref_fakultas';
$route['admin/fakultas/(:any)/(:any)']                  = 'admin/ref_fakultas';

$route['admin/prodi']                                   = 'admin/ref_prodi';
$route['admin/prodi/(:any)']                            = 'admin/ref_prodi';
$route['admin/prodi/(:any)/(:any)']                     = 'admin/ref_prodi';

$route['admin/group']                                   = 'admin/user';
$route['admin/group/(:any)']                            = 'admin/user';
$route['admin/group/(:any)/(:any)']                     = 'admin/user';

$route['admin/user']                                    = 'admin/user';
$route['admin/user/(:any)']                             = 'admin/user';
$route['admin/user/(:any)/(:any)']                      = 'admin/user';

$route['admin/log_user']                                = 'admin/user';

$route['admin/setwsapi']                                = 'admin/setting';
$route['admin/setwsapi/(:any)']                         = 'admin/setting';

$route['admin/setnilai']                                = 'admin/setting';
$route['admin/setnilai/(:any)']                         = 'admin/setting';
$route['admin/setnilai/(:any)/(:any)']                  = 'admin/setting';

$route['admin/setbobotnilai']                           = 'admin/setting';
$route['admin/setbobotnilai/(:any)']                    = 'admin/setting';
$route['admin/setbobotnilai/(:any)/(:any)']             = 'admin/setting';

$route['admin/agama']                                   = 'admin/master';
$route['admin/agama/(:any)']                            = 'admin/master';
$route['admin/agama/(:any)/(:any)']                     = 'admin/master';

$route['admin/statuspeg']                               = 'admin/master';
$route['admin/statuspeg/(:any)']                        = 'admin/master';
$route['admin/statuspeg/(:any)/(:any)']                 = 'admin/master';

$route['admin/jalur']                                   = 'admin/master';
$route['admin/jalur/(:any)']                            = 'admin/master';
$route['admin/jalur/(:any)/(:any)']                     = 'admin/master';

$route['admin/statusmhs']                               = 'admin/master';
$route['admin/statusmhs/(:any)']                        = 'admin/master';
$route['admin/statusmhs/(:any)/(:any)']                 = 'admin/master';

// management
$route['management/profile']                            = 'management';
$route['management/profile/(:any)']                     = 'management';

$route['management/tahunakademik']                      = 'management';
$route['management/tahunakademik/(:any)']               = 'management';
$route['management/tahunakademik/(:any)/(:any)']        = 'management';

$route['management/gedung']                             = 'management/gedung';
$route['management/gedung/(:any)']                      = 'management/gedung';
$route['management/gedung/(:any)/(:any)']               = 'management/gedung';

$route['management/ruang']                              = 'management/gedung';
$route['management/ruang/(:any)']                       = 'management/gedung';
$route['management/ruang/(:any)/(:any)']                = 'management/gedung';

$route['management/direktur']                           = 'management/direktur';
$route['management/direktur/(:any)']                    = 'management/direktur';
$route['management/direktur/(:any)/(:any)']             = 'management/direktur';

$route['management/kaprodi']                            = 'management/prodi';
$route['management/kaprodi/(:any)']                     = 'management/prodi';
$route['management/kaprodi/(:any)/(:any)']              = 'management/prodi';

$route['management/prodi']                              = 'management/prodi';
$route['management/prodi/(:any)']                       = 'management/prodi';
$route['management/prodi/(:any)/(:any)']                = 'management/prodi';

$route['management/jamkuliah']                          = 'management/jam';
$route['management/jamkuliah/(:any)']                   = 'management/jam';
$route['management/jamkuliah/(:any)/(:any)']            = 'management/jam';

$route['management/bobotnilai']                         = 'management/bobot_nilai';
$route['management/bobotnilai/(:any)']                  = 'management/bobot_nilai';
$route['management/bobotnilai/(:any)/(:any)']           = 'management/bobot_nilai';

$route['management/mastermhs']                          = 'management/master_data';
$route['management/mastermhs/(:any)']                   = 'management/master_data';
$route['management/mastermhs/(:any)/(:any)']            = 'management/master_data';
$route['management/mastermhs/(:any)/(:any)/(:any)']     = 'management/master_data';

$route['management/cutistudi']                          = 'management/master_data';
$route['management/cutistudi/(:any)']                   = 'management/master_data';
$route['management/cutistudi/(:any)/(:any)']            = 'management/master_data';
$route['management/cutistudi/(:any)/(:any)/(:any)']     = 'management/master_data';

$route['management/pegawai']                            = 'management/pegawai';
$route['management/pegawai/(:any)']                     = 'management/pegawai';
$route['management/pegawai/(:any)/(:any)']              = 'management/pegawai';
$route['management/pegawai/(:any)/(:any)/(:any)']       = 'management/pegawai';

$route['management/kelas']                              = 'management/kelas';
$route['management/kelas/(:any)']                       = 'management/kelas';
$route['management/kelas/(:any)/(:any)']                = 'management/kelas';

$route['management/krs']                                = 'management/krs';
$route['management/krs/(:any)']                         = 'management/krs';
$route['management/krs/(:any)/(:any)']                  = 'management/krs';

// Prodi
$route['prodi']                                         = 'prodi/index';
$route['prodi/kurikulum']                               = 'prodi/kurikulum';
$route['prodi/kurikulum/(:any)']                        = 'prodi/kurikulum';
$route['prodi/kurikulum/(:any)/(:any)']                 = 'prodi/kurikulum';
$route['prodi/kurikulum/(:any)/(:any)/(:any)']          = 'prodi/kurikulum';

$route['prodi/mata_kuliah']                             = 'prodi/mata_kuliah';
$route['prodi/mata_kuliah/(:any)']                      = 'prodi/mata_kuliah';
$route['prodi/mata_kuliah/(:any)/(:any)']               = 'prodi/mata_kuliah';
$route['prodi/mata_kuliah/(:any)/(:any)/(:any)']        = 'prodi/mata_kuliah';

$route['prodi/pegawai']                                 = 'prodi/pegawai';
$route['prodi/pegawai/(:any)']                          = 'prodi/pegawai';
$route['prodi/pegawai/(:any)/(:any)']                   = 'prodi/pegawai';
$route['prodi/pegawai/(:any)/(:any)/(:any)']            = 'prodi/pegawai';

$route['prodi/mahasiswa']                               = 'prodi/mahasiswa';
$route['prodi/mahasiswa/(:any)']                        = 'prodi/mahasiswa';
$route['prodi/mahasiswa/(:any)/(:any)']                 = 'prodi/mahasiswa';

$route['prodi/bagikelas']                               = 'prodi/kelas';
$route['prodi/bagikelas/(:any)']                        = 'prodi/kelas';
$route['prodi/bagikelas/(:any)/(:any)']                 = 'prodi/kelas';
$route['prodi/bagikelas/(:any)/(:any)/(:any)']          = 'prodi/kelas';

$route['prodi/rombel']                                  = 'prodi/kelas';
$route['prodi/rombel/(:any)']                           = 'prodi/kelas';
$route['prodi/rombel/(:any)/(:any)']                    = 'prodi/kelas';

$route['prodi/krs']                                     = 'prodi/krs';
$route['prodi/krs/(:any)']                              = 'prodi/krs';
$route['prodi/krs/(:any)/(:any)']                       = 'prodi/krs';

$route['prodi/mk_tawarkan']                             = 'prodi/Mk_ditawarkan';
$route['prodi/mk_tawarkan/(:any)']                      = 'prodi/mk_ditawarkan';
$route['prodi/mk_tawarkan/(:any)/(:any)']               = 'prodi/mk_ditawarkan';
$route['prodi/mk_tawarkan/(:any)/(:any)/(:any)']        = 'prodi/mk_ditawarkan';

$route['prodi/reportkrs']                               = 'prodi/report_krs';
$route['prodi/reportkrs/(:any)']                        = 'prodi/report_krs';
$route['prodi/reportkrs/(:any)/(:any)']                 = 'prodi/report_krs';
$route['prodi/reportkrs/(:any)/(:any)/(:any)']          = 'prodi/report_krs';

$route['prodi/reportkhs']                               = 'prodi/report_khs';
$route['prodi/reportkhs/(:any)']                        = 'prodi/report_khs';
$route['prodi/reportkhs/(:any)/(:any)']                 = 'prodi/report_khs';
$route['prodi/reportkhs/(:any)/(:any)/(:any)']          = 'prodi/report_khs';

$route['prodi/jadwal']                                  = 'prodi/jadwal';
$route['prodi/jadwal/(:any)']                           = 'prodi/jadwal';
$route['prodi/jadwal/(:any)/(:any)']                    = 'prodi/jadwal';
$route['prodi/jadwal/(:any)/(:any)/(:any)']             = 'prodi/jadwal';

$route['prodi/nilai_akhir']                             = 'prodi/nilai_akhir';
$route['prodi/nilai_akhir/(:any)']                      = 'prodi/nilai_akhir';
$route['prodi/nilai_akhir/(:any)/(:any)']               = 'prodi/nilai_akhir';
$route['prodi/nilai_akhir/(:any)/(:any)/(:any)']        = 'prodi/nilai_akhir';

// Dosen
$route['dosen/profil']                                  = 'dosen/profil';
$route['dosen/profil/(:any)']                           = 'dosen/profil';
$route['dosen/profil/(:any)/(:any)']                    = 'dosen/profil';

$route['dosen/akademik']                                = 'dosen/akademik';
$route['dosen/akademik/(:any)']                         = 'dosen/akademik';
$route['dosen/akademik/(:any)/(:any)']                  = 'dosen/akademik';

$route['dosen/nilai']                                   = 'dosen/nilai';
$route['dosen/nilai/(:any)']                            = 'dosen/nilai';
$route['dosen/nilai/(:any)/(:any)']                     = 'dosen/nilai';

$route['dosen/keamanan']                                = 'dosen/keamanan';
$route['dosen/keamanan/(:any)']                         = 'dosen/keamanan';

// mahasiswa
$route['mahasiswa/profil']                              = 'mahasiswa/profil';
$route['mahasiswa/profil/(:any)']                       = 'mahasiswa/profil';
$route['mahasiswa/profil/(:any)/(:any)']                = 'mahasiswa/profil';

$route['mahasiswa/keamanan']                            = 'mahasiswa/keamanan';
$route['mahasiswa/keamanan/(:any)']                     = 'mahasiswa/keamanan';

$route['mahasiswa/akademik']                            = 'mahasiswa/akademik';
$route['mahasiswa/akademik/(:any)']                     = 'mahasiswa/akademik';
$route['mahasiswa/akademik/(:any)/(:any)']              = 'mahasiswa/akademik';

$route['mahasiswa/laporan']                             = 'mahasiswa/laporan';
$route['mahasiswa/laporan/(:any)']                      = 'mahasiswa/laporan';
$route['mahasiswa/laporan/(:any)/(:any)']               = 'mahasiswa/laporan';
$route['mahasiswa/laporan/(:any)/(:any)/(:any)']        = 'mahasiswa/laporan';

$route['mahasiswa/tagihan']                             = 'mahasiswa/tagihan';
$route['mahasiswa/tagihan/(:any)']                      = 'mahasiswa/tagihan';
$route['mahasiswa/tagihan/(:any)/(:any)']               = 'mahasiswa/tagihan';
$route['mahasiswa/tagihan/(:any)/(:any)/(:any)']        = 'mahasiswa/tagihan';
