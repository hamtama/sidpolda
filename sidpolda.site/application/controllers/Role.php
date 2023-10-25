<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Role extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Role_model");
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Halaman Role';
        $data['cb_menu'] = $this->Role_model->show_menu();
        $data['user'] = $this->Role_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('administrator/role', $data);
        $this->load->view('template/footer');
        $this->load->view('administrator/fungsi_role', $data);
    }


    public function access_menu($id)
    {
        $data['title'] = 'Halaman Access Menu';
        $data['cb_menu'] = $this->Role_model->show_menu();
        $data['user'] = $this->Role_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['akses'] = $this->db->get_where('user_role', ['id_role' => $this->uri->segment('3')])->row_array();
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('administrator/user_access_menu', $data);
        $this->load->view('template/footer');
        $this->load->view('administrator/fungsi_useraccess', $data);
    }
    // Function Add Data
    public function add()
    {
        $this->_validation();
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['role'],
                'error' => [
                    'role' => form_error('role'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Role_model->add_role();
        }
    }

    // Function Update Data
    public function update()
    {
        $this->form_validation->set_rules(
            'role',
            'Role',
            'required|trim',
            array(
                'required' => 'Kolom Role Tidak Boleh Kosong',
            )
        );


        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['role'],
                'error' => [
                    'role' => form_error('role'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Role_model->update_role();
        }
    }

    // Function Delete Data
    public function delete($id)
    {
        $this->Role_model->delete_role($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('role');
    }

    public function deaktifasi()
    {
        $this->Role_model->deaktifasi_menu();
    }

    public function aktifasi()
    {
        $this->Role_model->aktifasi_menu();
    }

    // Function Show Data In Modal
    public function edit_select()
    {
        $data = $this->db->get_where('user_role', ['id_role' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }

    // Fungsi Validation for Add Data
    public function _validation()
    {
        $this->form_validation->set_rules(
            'role',
            'Role',
            'required|trim|is_unique[user_role.role]',
            array(
                'required' => 'Kolom Role Tidak Boleh Kosong',
                'is_unique' => 'Role sudah ada tidak dapat digunakan'
            )
        );
    }
}
