<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Surat_Disposisi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Disposisi_model"); //load model mahasiswa
        is_logged_in();
    }
    public function index()
    {
        // $data['perihal'] = $this->SK_model->show_perihal();
        $data['user'] = $this->Disposisi_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Surat Keluar';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/surat_disposisi', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_dis', $data);
    }
}
