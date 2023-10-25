<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Submenu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Submenu_model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {
        $data['cb_menu'] = $this->Submenu_model->show_menu();
        $data['user'] = $this->Submenu_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Submenu';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('administrator/sub_menu', $data);
        $this->load->view('template/footer');
        $this->load->view('administrator/fungsi_submenu', $data);
    }

    // Function Add Data
    public function add()
    {
        $this->_validation();
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['menu', 'title', 'url',],
                'error' => [
                    'menu' => form_error('menu'),
                    'title' => form_error('title'),
                    'url' => form_error('url'),
                    'aktif' => form_error('aktif'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Submenu_model->add_submenu();
        }
    }

    // Function Update Data
    public function update()
    {
        $this->form_validation->set_rules(
            'menu',
            'Menu',
            'required|trim',
            array(
                'required' => 'Kolom Menu Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'title',
            'Title',
            'required|trim',
            array(
                'required' => 'Kolom Title Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'url',
            'URL',
            'required|trim',
            array(
                'required' => 'Kolom URL Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['menu', 'title', 'url'],
                'error' => [
                    'menu' => form_error('menu'),
                    'title' => form_error('ikon'),
                    'url' => form_error('urutan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Submenu_model->update_submenu();
        }
    }

    public function aktifasi()
    {
        $this->Submenu_model->aktifasi_submenu();
    }
    // Function Delete Data
    public function delete($id)
    {
        $this->Submenu_model->delete_submenu($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('submenu');
    }

    // Function Show Data In Modal
    public function edit_select()
    {
        $data = $this->db->get_where('user_sub_menu', ['id_sub_menu' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }

    // Fungsi Validation for Add Data
    public function _validation()
    {
        $this->form_validation->set_rules(
            'menu',
            'Menu',
            'required|trim',
            array(
                'required' => 'Kolom Menu Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'title',
            'Title',
            'required|trim|is_unique[user_sub_menu.title]',
            array(
                'required' => 'Kolom Title Tidak Boleh Kosong',
                'is_unique' => 'Title sudah ada tidak dapat digunakan'
            )
        );
        $this->form_validation->set_rules(
            'url',
            'Url',
            'required|trim',
            array(
                'required' => 'Kolom Url Tidak Boleh Kosong',
            )
        );
    }
}
