<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Status extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Status_model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {
        $data['user'] = $this->Status_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Status';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/status', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_status', $data);
    }

    // Function Add Data
    public function add()
    {
        $this->_validation();
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['status', 'warna'],
                'error' => [
                    'status' => form_error('status'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Status_model->add_status();
        }
    }
    // Function Show Data In Modal
    public function edit_select()
    {
        $data = $this->db->get_where('tb_status', ['id_status' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }
    // Function Update Data
    public function update()
    {
        $this->form_validation->set_rules(
            'status',
            'Status',
            'required|trim',
            array(
                'required' => 'Kolom Status Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'warna',
            'Warna',
            'required|trim',
            array(
                'required' => 'Kolom Warna Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['status', 'warna'],
                'error' => [
                    'status' => form_error('status'),

                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Status_model->update_status();
        }
    }


    // Function Delete Data
    public function delete($id)
    {
        $this->Status_model->delete_status($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('status');
    }



    // Fungsi Validation for Add Data
    public function _validation()
    {
        $this->form_validation->set_rules(
            'status',
            'Status',
            'required|trim|is_unique[tb_status.status]',
            array(
                'required' => 'Kolom Status Tidak Boleh Kosong',
                'is_unique' => 'Status Sudah Ada Silahkan Ganti Status Lain'
            )
        );
        $this->form_validation->set_rules(
            'warna',
            'Warna',
            'required|trim|is_unique[tb_status.warna]',
            array(
                'required' => 'Kolom Status Tidak Boleh Kosong',
                'is_unique' => 'Warna Sudah Ada Silahkan Ganti Status Lain'
            )
        );
    }
}
