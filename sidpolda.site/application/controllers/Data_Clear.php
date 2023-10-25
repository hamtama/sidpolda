<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Data_Clear extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Data_Clear_model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {
        $data['cb_kejahatan'] = $this->Data_Clear_model->show_kejahatan();
        $data['polres'] = $this->Data_Clear_model->polres();
        $data['kabupaten'] = $this->Data_Clear_model->kabupaten();
        $data['user'] = $this->Data_Clear_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Kejahatan Sukses';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/data_cc', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_data_cc', $data);
    }

      
   


    // ================== INPUT DATA KEJAHATAN =============================
    public function add_data_cc()
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
            'jumlah_cc',
            'Jumlah Crime Clearance',
            'required|trim',
            array(
                'required' => 'Kolom Jumlah Crime Clearance Tidak Boleh Kosong'
            )
        );
        
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['tgl_kejadian', 'polres', 'kabupaten' ,'kejahatan', 'jumlah_cc' ],
                'error' => [
                    'tgl_kejadian' => form_error('tgl_kejadian'),
                    'polres' => form_error('polres'),
                    'kabupaten' => form_error('kabupaten'),
                    'kejahatan' => form_error('kejahatan'),
                    'jumlah_cc' => form_error('jumlah_cc'),
                   
                    
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Data_Clear_model->add_data_cc();
        }
    }

    // Function Show Data In Modal
    public function edit_select_cc()
    {
        $this->db->select('*, tb_data_cc.id_kejahatan as id_kej, tb_data_cc.id_kabupaten as id_kab');
        $this->db->from('tb_data_cc');
        $this->db->join('tb_kejahatan', 'tb_data_cc.id_kejahatan = tb_kejahatan.id_kejahatan', 'left');
        $this->db->join('tb_kabupaten', 'tb_data_cc.id_kabupaten = tb_kabupaten.id_kabupaten', 'left');
        $this->db->where('id_data_cc', $this->input->post('id'));
        $data =  $this->db->get()->row_array();
        // $data2 = $this->db->get_where('tb_dis_sm', ['id_surat_masuk' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }

    public function update_data_cc()
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
            'jumlah_cc',
            'Jumlah Crime Clearance',
            'required|trim',
            array(
                'required' => 'Kolom Jumlah Crime Clearance Tidak Boleh Kosong'
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['tgl_kejadian', 'polres', 'kabupaten','kejahatan', 'jumlah_cc'],
                'error' => [
                    'tgl_kejadian' => form_error('tgl_kejadian'),
                    'polres' => form_error('polres'),
                    'kabupaten' => form_error('kabupaten'),
                    'kejahatan' => form_error('kejahatan'),
                    'jumlah_cc' => form_error('jumlah_cc'),
                    
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Data_Clear_model->update_data_cc();
        }
    }

    public function delete_data_cc($id)
    {
        $this->Data_Clear_model->delete_data_cc($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('Data_Clear');
    }



    // ================== FILTERING DATA =============================
    public function list()
    {
        $postData = $this->input->post();
        $data = $this->Data_Clear_model->getUsers($postData);
        echo json_encode($data);
    }
}