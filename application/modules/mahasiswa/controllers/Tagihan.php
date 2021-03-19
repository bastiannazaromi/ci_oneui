<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        mhs_init();
        $params = array('server_key' => 'SB-Mid-server-LkgLKS1Z4R3zutWhX5aNlB3f', 'production' => false);
        $this->load->library('midtrans');
        $this->midtrans->config($params);
    }
    public function index()
    {
        if ($this->u2 == 'tagihan') {
            if ($this->u3 == 'token_snap') {
                $id_tagihan = $this->input->post('id_tagihan');
                $item_details = [];
                $nominal = 0;
                foreach ($id_tagihan as $row) {
                    $getNominal = $this->mhs->getTagihanOne(['tagihan.id' => dekrip($row)]);
                    $nominal += $getNominal->nominal;
                    array_push($item_details, [
                        'id' => dekrip($row),
                        'price' => $getNominal->nominal,
                        'quantity' => 1,
                        'name' => $getNominal->nama_mp . ' ' . $getNominal->nama_rbp,
                    ]);
                }
                array_push($item_details, [
                    'id' => '4',
                    'price' => '6000',
                    'quantity' => 1,
                    'name' => 'Biaya Admin Payment Gateway',
                ]);
                $transaction_details = array(
                    'order_id' => rand(),
                    'gross_amount' => $nominal + 6000,
                );
                $billing_address = array(
                    'first_name'    => "Politeknik Harapan Bersama",
                    'last_name'     => "Online Academik Service",
                    'address'       => "Mangga 20",
                    'city'          => "Kota Tegal",
                    'postal_code'   => "16602",
                    'phone'         => "081122334455",
                    'country_code'  => 'IDN'
                );
                $customer_details = array(
                    'first_name'    => $this->user->nama_lengkap,
                    'email'         => ($this->user->email == '' || $this->user->email == null) ? 'admin@poltektegal.ac.id' : $this->user->email,
                    'phone'         => $this->user->no_hp,
                    'billing_address'  => $billing_address,
                );
                $custom_expiry = array(
                    'start_time' => date("Y-m-d H:i:s O", time()),
                    'unit' => 'minute',
                    'duration'  => 3060
                );
                $transaction_data = array(
                    'transaction_details' => $transaction_details,
                    'item_details'       => $item_details,
                    'customer_details'   => $customer_details,
                    'expiry'             => $custom_expiry
                );
                error_log(json_encode($transaction_data));
                $snapToken = $this->midtrans->getSnapToken($transaction_data);
                echo $snapToken;
            } else if ($this->u3 == 'riwayat'){
                $params = array('title' => 'Riwayat Pembayaran');    
                $this->load->view('riwayat_pembayaran', $params);
            } else {
                $params = [
                    'title' => 'Data Tagihan Mahasiswa',
                    'tagihan' => $this->mhs->getTagihanMhs(['nim' => $this->user->nim, 'status' => 0]),
                    'tahun_akademik' => $this->universal->getOne(['status' => 1], 'tahun_akademik'),
                ];
                $this->load->view('tagihan', $params);
            }
        }
    }
}
