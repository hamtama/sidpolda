<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Surat_Keluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("SK_model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {
        $data['perihal'] = $this->SK_model->show_perihal();
        $data['user'] = $this->SK_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Surat Keluar';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/surat_keluar', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_sk', $data);
    }

    // Function Add Data
    public function add()
    {
        $this->_validation();
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['no_surat_masuk', 'tgl_surat', 'tujuan', 'perihal', 'keterangan'],
                'error' => [
                    'no_surat_keluar' => form_error('no_surat_keluar'),
                    'tgl_surat' => form_error('tgl_surat'),
                    'tujuan' => form_error('tujuan'),
                    'perihal' => form_error('perihal'),
                    'keterangan' => form_error('keterangan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $upload_file = $_FILES['file_sk']['name'];
            if ($upload_file) {
                $config['upload_path']      = './assets/file_upload/surat_keluar';
                $config['allowed_types']    = 'pdf';
                $config['max_size']         = '5000';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file_sk')) {
                    $new_file = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                }
            }
            $data = [
                'no_surat_keluar'       => $this->input->post('no_surat', true),
                'tgl_surat'             => $this->input->post('tgl_surat', true),
                'tujuan'                => $this->input->post('tujuan', true),
                'file_sk'               => $new_file,
                'perihal'               => $this->input->post('perihal', true),
                'keterangan'            => $this->input->post('keterangan', true),
                'status'                => '1'
            ];
            $this->SK_model->add_surat_keluar($data);
        }
    }

    // Function Update Data
    public function update()
    {
        $data['update'] = $this->db->get_where('tb_surat_keluar', ['id_surat_keluar' => $this->input->post('id', true)])->row_array();
        $this->_validation();
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['no_surat', 'tgl_surat', 'tujuan', 'perihal', 'keterangan'],
                'error' => [
                    'no_surat'      => form_error('no_surat'),
                    'tgl_surat'     => form_error('tgl_surat'),
                    'tujuan'        => form_error('tujuan'),
                    'perihal'       => form_error('perihal'),
                    'keterangan'       => form_error('keterangan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $upload_file = $_FILES['file_sk']['name'];
            if ($upload_file) {
                $config['upload_path']          = './assets/file_upload/surat_keluar';
                $config['allowed_types']        = 'pdf';
                $config['max_size']             = '5000';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file_sk')) {
                    $old_file = $data['update']['file_sk'];
                    if ($old_file != $upload_file) {
                        unlink(FCPATH . 'assets/file_upload/surat_keluar/' . $old_file);
                    }
                    $new_file = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                }
            } else {
                $new_file = $data['update']['file_sk'];
            }

            $data = [
                'no_surat_keluar'  => $this->input->post('no_surat', true),
                'tgl_surat' => $this->input->post('tgl_surat', true),
                'tujuan' => $this->input->post('asal_surat', true),
                'file_sk' => $new_file,
                'perihal' => $this->input->post('perihal', true),
                'keterangan' => $this->input->post('keterangan', true),
            ];
            $this->SK_model->update_sk($data);
        }
    }


    // Function Delete Data
    public function delete($id)
    {
        $data['delete'] = $this->db->get_where('tb_surat_keluar', ['id_surat_keluar' => $id])->row_array();
        unlink(FCPATH . 'assets/file_upload/surat_keluar/' . $data['delete']['file_sk']);
        $this->SK_model->delete_sk($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('surat_keluar');
    }

    // Function Show Data In Modal
    public function edit_select()
    {
        $data = $this->db->get_where('tb_surat_keluar', ['id_surat_keluar' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }
    public function select_dis()
    {
        $this->db->select('*');
        $this->db->from('tb_dis_sk');
        $this->db->join('tb_surat_keluar', 'tb_dis_sk.id_surat_keluar = tb_surat_keluar.id_surat_keluar');
        $this->db->where('tb_dis_sk.id_surat_keluar', $this->input->post('id'));
        $data =  $this->db->get()->row_array();
        // $data2 = $this->db->get_where('tb_dis_sm', ['id_surat_masuk' => $this->input->post('id')])->row_array();
        echo json_encode($data);
    }

    public function select_dis2()
    {
        $this->db->select('`*` , tb_dis_sk.tanggal AS tgl, tb_dis_sk.keterangan AS ket');
        $this->db->from('tb_dis_sk');
        $this->db->join('tb_surat_keluar', 'tb_dis_sk.id_surat_keluar = tb_surat_keluar.id_surat_keluar');
        $this->db->join('tb_dl_sk', 'tb_dis_sk.id_surat_keluar = tb_dl_sk.id_surat_keluar');
        $this->db->where('tb_dis_sk.id_surat_keluar', $this->input->post('id'));
        $data2 =  $this->db->get()->row_array();
        // $data2 = $this->db->get_where('tb_dis_sm', ['id_surat_masuk' => $this->input->post('id')])->row_array();
        echo json_encode($data2);
    }


    // Fungsi Validation for Add Data
    public function _validation()
    {
        $this->form_validation->set_rules(
            'tgl_surat',
            'Tanggal Surat',
            'required|trim',
            array(
                'required' => 'Kolom Tanggal Surat Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'no_surat',
            'No Surat',
            'required|trim',
            array(
                'required' => 'Kolom No Surat Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'tujuan',
            'Tujuan',
            'required|trim',
            array(
                'required' => 'Kolom Tujuan Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'perihal',
            'Perihal',
            'required|trim',
            array(
                'required' => 'Kolom Perihal Tidak Boleh Kosong.',
            )
        );
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required|trim',
            array(
                'required' => 'Kolom Isi Ringkasan Tidak Boleh Kosong.',
            )
        );
    }

    // ============================= HALAMAN DISPOSISI SURAT KELUAR =================================

    public function dis_sk()
    {
        $data['user'] = $this->SK_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Disposisi Surat Keluar';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/dis_sk', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_dis_sk', $data);
    }
    public function add_dis_sk()
    {
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required|trim',
            array(
                'required' => 'Kolom Keterangan Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['keterangan'],
                'error' => [
                    'keterangan' => form_error('keterangan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $date = date("Y-m-d h:i:sa");
            $data = [
                'keterangan'        => $this->input->post('keterangan', true),
                'id_surat_keluar'    => $this->input->post('id', true),
                'tanggal'           => $date
            ];
            $this->db->insert('tb_dis_sk', $data);

            $data2 = [
                'status'        => 3,
            ];
            $this->db->where('id_surat_keluar', $this->input->post('id', true));
            $this->db->update('tb_surat_keluar', $data2);
        }
    }
    public function del_dis_sk($id)
    {

        $this->db->where('id_surat_keluar', $id);
        $this->db->delete('tb_dis_sk');
        $data2 = [
            'status'        => 1,
        ];
        $this->db->where('id_surat_keluar', $id);
        $this->db->update('tb_surat_keluar', $data2);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('surat_keluar/dis_sk');
    }

    public function reject_dis_sk()
    {
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required|trim',
            array(
                'required' => 'Kolom Keterangan Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['keterangan'],
                'error' => [
                    'keterangan' => form_error('keterangan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $date = date("Y-m-d h:i:sa");
            $data = [
                'keterangan'        => $this->input->post('keterangan', true),
                'id_surat_keluar'    => $this->input->post('id', true),
                'tanggal'           => $date
            ];
            $this->db->insert('tb_dis_sk', $data);

            $data2 = [
                'status'        => 6,
            ];
            $this->db->where('id_surat_keluar', $this->input->post('id', true));
            $this->db->update('tb_surat_keluar', $data2);
        }
    }

    // ============================= HALAMAN DISPOSISI LANJUT SURAT KELUAR =================================

    public function dl_sk()
    {
        $data['user'] = $this->SK_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Disposisi Lanjut Surat Keluar';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/dl_dis_sk', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_dl_sk', $data);
    }

    public function add_dl_sk()
    {
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required|trim',
            array(
                'required' => 'Kolom Keterangan Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['keterangan'],
                'error' => [
                    'keterangan' => form_error('keterangan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $date = date("Y-m-d h:i:sa");
            $data = [
                'keterangan'        => $this->input->post('keterangan', true),
                'id_surat_keluar'    => $this->input->post('id', true),
                'tanggal'           => $date
            ];
            $this->db->insert('tb_dl_sk', $data);

            $data2 = [
                'status'        => 4,
            ];
            $this->db->where('id_surat_keluar', $this->input->post('id', true));
            $this->db->update('tb_surat_keluar', $data2);
        }
    }
    public function del_dl_sk($id)
    {

        $this->db->where('id_surat_keluar', $id);
        $this->db->delete('tb_dl_sk');
        $data2 = [
            'status'        => 1,
        ];
        $this->db->where('id_surat_keluar', $id);
        $this->db->update('tb_surat_keluar', $data2);

        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('surat_keluar/dl_sk');
    }



    public function reject_dl_sk()
    {
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required|trim',
            array(
                'required' => 'Kolom Keterangan Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $msg = [
                'input' => ['keterangan'],
                'error' => [
                    'keterangan' => form_error('keterangan'),
                ]
            ];
            echo json_encode($msg);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $date = date("Y-m-d h:i:sa");
            $data = [
                'keterangan'        => $this->input->post('keterangan', true),
                'id_surat_keluar'    => $this->input->post('id', true),
                'tanggal'           => $date
            ];
            $this->db->insert('tb_dl_sk', $data);

            $data2 = [
                'status'        => 6,
            ];
            $this->db->where('id_surat_keluar', $this->input->post('id', true));
            $this->db->update('tb_surat_keluar', $data2);
        }
    }

    // ============================= HALAMAN LAPORAN SURAT KELUAR =================================

    public function lap_sk()
    {
        $data['user'] = $this->SK_model->dashboard();
        $data['perihal'] = $this->SK_model->show_perihal();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Laporan Surat Keluar';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/lap_sk', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_lap_sk', $data);
    }

    public function userList()
    {
        $postData = $this->input->post();
        $data = $this->SK_model->getUsers($postData);
        echo json_encode($data);
    }

    public function cetak()
    {
        $id = $this->input->post();
        $data = $this->SK_model->cetak_data($id);
        echo json_encode($data);
    }
}
