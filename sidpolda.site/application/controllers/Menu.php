<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Menu_model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {
        $data['cb_menu'] = $this->Menu_model->show_menu();
        $data['user'] = $this->Menu_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Menu';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('administrator/menu', $data);
        $this->load->view('template/footer');
        $this->load->view('administrator/fungsi', $data);
    }

    // Function Add Data
    public function add()
    {
        $this->_validation();
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['menu', 'ikon', 'urutan'],
                'error' => [
                    'menu' => form_error('menu'),
                    'ikon' => form_error('ikon'),
                    'urutan' => form_error('urutan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Menu_model->add_menu();
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
            'ikon',
            'Ikon',
            'required|trim',
            array(
                'required' => 'Kolom Ikon Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'urutan',
            'Urutan',
            'required|trim',
            array(
                'required' => 'Kolom Urutan Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['menu', 'ikon', 'urutan'],
                'error' => [
                    'menu' => form_error('menu'),
                    'ikon' => form_error('ikon'),
                    'urutan' => form_error('urutan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Menu_model->update_menu();
        }
    }
    public function aktifasi()
    {
        $this->Menu_model->aktifasi_menu();
    }
    // Function Delete Data
    public function delete($id)
    {
        $this->Menu_model->delete_menu($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('menu');
    }

    // Function Show Data In Modal
    public function edit_select()
    {
        $data = $this->db->get_where('user_menu', ['id_menu' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }

    // Fungsi Validation for Add Data
    public function _validation()
    {
        $this->form_validation->set_rules(
            'menu',
            'Menu',
            'required|trim|is_unique[user_menu.menu]',
            array(
                'required' => 'Kolom Menu Tidak Boleh Kosong',
                'is_unique' => 'Menu sudah ada tidak dapat digunakan'
            )
        );
        $this->form_validation->set_rules(
            'ikon',
            'Ikon',
            'required|trim',
            array(
                'required' => 'Kolom Ikon Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'urutan',
            'Urutan',
            'required|trim|is_unique[user_menu.urutan]',
            array(
                'required' => 'Kolom Urutan Tidak Boleh Kosong',
                'is_unique' => 'Urutan Sudah Terpakai'
            )
        );
    }
}
