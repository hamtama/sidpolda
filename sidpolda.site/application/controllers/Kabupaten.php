<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kabupaten extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Kabupaten_model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {
        $data['user'] = $this->Kabupaten_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Kabupaten';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/kabupaten', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_kabupaten', $data);
    }

    // Function Add Data
    public function add()
    {
        $this->_validation();
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['kabupaten'],
                'error' => [
                    'kabupaten' => form_error('kabupaten'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Kabupaten_model->add();
        }
    }
    // Function Show Data In Modal
    public function edit_select()
    {
        $data = $this->db->get_where('tb_kabupaten', ['id_kabupaten' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }
    // Function Update Data
    public function update()
    {
        $this->form_validation->set_rules(
            'kabupaten',
            'Kabupaten',
            'required|trim',
            array(
                'required' => 'Kolom Kabupaten Tidak Boleh Kosong',
            )
        );
       
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['kabupaten'],
                'error' => [
                    'kabupaten' => form_error('kabupaten'),

                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Kabupaten_model->update();
        }
    }


    // Function Delete Data
    public function delete($id)
    {
        $this->Kabupaten_model->delete($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('kabupaten');
    }



    // Fungsi Validation for Add Data
    public function _validation()
    {
        $this->form_validation->set_rules(
            'kabupaten',
            'Kabupaten',
            'required|trim|is_unique[tb_kabupaten.kabupaten]',
            array(
                'required' => 'Kolom Kabupaten Tidak Boleh Kosong',
                'is_unique' => 'Kabupaten Sudah Ada Silahkan Ganti Kabupaten Lain'
            )
        );
        
    }
}