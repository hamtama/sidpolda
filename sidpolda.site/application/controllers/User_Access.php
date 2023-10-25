<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_Access extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("User_Access_Model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {

        $data['user'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman User Access';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('administrator/user_access', $data);
        $this->load->view('template/footer');
        $this->load->view('administrator/fungsi_useraccess', $data);
    }




    public function deaktifasi()
    {
        $this->User_Access_Model->deaktifasi_menu();
    }

    public function aktifasi()
    {
        $this->User_Access_Model->aktifasi_menu();
    }
}
