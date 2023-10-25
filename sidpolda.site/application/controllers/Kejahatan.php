<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kejahatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Kejahatan_model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {
        $data['user'] = $this->Kejahatan_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Kejahatan';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/kejahatan', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_kejahatan', $data);
    }

    // function view input data kejahatan
    public function data_kejahatan()
    {
        $data['cb_kejahatan'] = $this->Kejahatan_model->show_kejahatan();
        $data['polres'] = $this->Kejahatan_model->polres();
        $data['kabupaten'] = $this->Kejahatan_model->kabupaten();
        $data['user'] = $this->Kejahatan_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Input Data Kejahatan';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/i_kejahatan', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_ikejahatan', $data);
    }

    // Function Add Data
    public function add()
    {
        $this->_validation();
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['kejahatan'],
                'error' => [
                    'kejahatan' => form_error('kejahatan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Kejahatan_model->add_kejahatan();
        }
    }
    // Function Show Data In Modal
    public function edit_select()
    {
        $data = $this->db->get_where('tb_kejahatan', ['id_kejahatan' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }
    // Function Update Data
    public function update()
    {
        $this->form_validation->set_rules(
            'kejahatan',
            'Kejahatan',
            'required|trim',
            array(
                'required' => 'Kolom Kejahatan Tidak Boleh Kosong',
            )
        );
        
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['kejahatan'],
                'error' => [
                    'kejahatan' => form_error('kejahatan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Kejahatan_model->update_kejahatan();
        }
    }


    // Function Delete Data
    public function delete($id)
    {
        $this->Kejahatan_model->delete_kejahatan($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('kejahatan');
    }



    // Fungsi Validation for Add Data
    public function _validation()
    {
        $this->form_validation->set_rules(
            'kejahatan',
            'Kejahatan',
            'required|trim|is_unique[tb_kejahatan.kejahatan]',
            array(
                'required' => 'Kolom Kejahatan Tidak Boleh Kosong',
                'is_unique' => 'Nama %s Sudah Ada'
            )
        );
        
    }


    // ================== INPUT DATA KEJAHATAN =============================
    public function add_ikejahatan()
    {
        $this->form_validation->set_rules(
            'tgl_kejadian',
            'Tanggal Kejadian',
            'required|trim',
            array(
                'required' => 'Kolom Tanggal Kejadian Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'polres',
            'Polres',
            'required|trim',
            array(
                'required' => 'Kolom Polres Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'kejahatan',
            'Kejahatan',
            'required|trim',
            array(
                'required' => 'Kolom Kejahatan Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'kabupaten',
            'Kabupaten',
            'required|trim',
            array(
                'required' => 'Kolom Jumlah Kabupaten Tidak Boleh Kosong'
            )
        );

        $this->form_validation->set_rules(
            'jumlah_kejahatan',
            'Jumlah Kejahatan',
            'required|trim',
            array(
                'required' => 'Kolom Jumlah Kejahatan Tidak Boleh Kosong'
            )
        );
        
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['tgl_kejadian', 'polres', 'kabupaten' ,'kejahatan', 'jumlah_kejahatan' ],
                'error' => [
                    'tgl_kejadian' => form_error('tgl_kejadian'),
                    'polres' => form_error('polres'),
                    'kabupaten' => form_error('kabupaten'),
                    'kejahatan' => form_error('kejahatan'),
                    'jumlah_kejahatan' => form_error('jumlah_kejahatan'),
                   
                    
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Kejahatan_model->add_data_kejahatan();
        }
    }

    // Function Show Data In Modal
    public function edit_select_ikejahatan()
    {
        $this->db->select('*, tb_data_kejahatan.id_kejahatan as id_kej, tb_data_kejahatan.id_kabupaten as id_kab');
        $this->db->from('tb_data_kejahatan');
        $this->db->join('tb_kejahatan', 'tb_data_kejahatan.id_kejahatan = tb_kejahatan.id_kejahatan', 'left');
        $this->db->join('tb_kabupaten', 'tb_data_kejahatan.id_kabupaten = tb_kabupaten.id_kabupaten', 'left');
        $this->db->where('id_data_kejahatan', $this->input->post('id'));
        $data =  $this->db->get()->row_array();
        // $data2 = $this->db->get_where('tb_dis_sm', ['id_surat_masuk' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }

    public function update_ikejahatan()
    {
        $this->form_validation->set_rules(
            'tgl_kejadian',
            'Tanggal Kejadian',
            'required|trim',
            array(
                'required' => 'Kolom Tanggal Kejadian Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'polres',
            'Polres',
            'required|trim',
            array(
                'required' => 'Kolom Polres Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'kejahatan',
            'Kejahatan',
            'required|trim',
            array(
                'required' => 'Kolom Kejahatan Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'kabupaten',
            'Kabupaten',
            'required|trim',
            array(
                'required' => 'Kolom Jumlah Kabupaten Tidak Boleh Kosong'
            )
        );
        $this->form_validation->set_rules(
            'jumlah_kejahatan',
            'Jumlah Kejahatan',
            'required|trim',
            array(
                'required' => 'Kolom Jumlah Kejahatan Tidak Boleh Kosong'
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['tgl_kejadian', 'polres', 'kabupaten','kejahatan', 'jumlah_kejahatan'],
                'error' => [
                    'tgl_kejadian' => form_error('tgl_kejadian'),
                    'polres' => form_error('polres'),
                    'kabupaten' => form_error('kabupaten'),
                    'kejahatan' => form_error('kejahatan'),
                    'jumlah_kejahatan' => form_error('jumlah_kejahatan'),
                    
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Kejahatan_model->update_data_kejahatan();
        }
    }

    public function delete_data_kejahatan($id)
    {
        $this->Kejahatan_model->delete_data_kejahatan($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('kejahatan/data_kejahatan');
    }



    // ================== FILTERING DATA =============================
    public function list()
    {
        $postData = $this->input->post();
        $data = $this->Kejahatan_model->getUsers($postData);
        echo json_encode($data);
    }
}