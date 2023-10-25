<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Polres extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Polres_model');
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->Polres_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Polres';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/polres', $data);
        $this->load->view('template/footer');
        // $this->load->view('user/fungsi_kejahatan', $data);
    }

    public function polres_add()
    {
        $data['user'] = $this->Polres_model->dashboard();
        $data['map'] = $this->Polres_model->map();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Tambah Polres';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/polres_add', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_polres_add', $data);
        // $this->load->view('user/fungsi_map', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules(
            'nama_polres',
            'Nama Polres',
            'required|trim|is_unique[tb_polres.nama_polres]',
            array(
                'required' => 'Kolom Nama Polres Tidak Boleh Kosong',
                'is_unique' => 'Nama Polres $s Sudah Terpakai'
            )
        );
        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'required|trim',
            array(
                'required' => 'Kolom Alamat Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'kontak',
            'Kontak',
            'required|trim',
            array(
                'required' => 'Kolom Kontak Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim',
            array(
                'required' => 'Kolom Email Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'latitude',
            'Latitude',
            'required|trim',
            array(
                'required' => 'Kolom Latitude Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'longitude',
            'Longitude',
            'required|trim',
            array(
                'required' => 'Kolom Longitude Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'deskripsi',
            'Deskripsi',
            'required|trim',
            array(
                'required' => 'Kolom Deskripsi Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $data['map'] = $this->Polres_model->map();
            $data['user'] = $this->Polres_model->dashboard();
            $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
            $data['title'] = 'Halaman Tambah Polres';
            $this->load->view('template/head', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/header', $data);
            $this->load->view('user/polres_add', $data);
            $this->load->view('template/footer');
            $this->load->view('user/fungsi_polres_add', $data);
            $this->load->view('user/fungsi_map', $data);
        } else {
            $upload_file = $_FILES['file_image']['name'];
            $new_file = '';
            if ($upload_file) {
                $config['upload_path']          = './assets/file_upload/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['max_size']             = '5000';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('file_image')) {
                    $new_file = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $data = [
                'nama_polres' => $this->input->post('nama_polres', true),
                'gambar' => $new_file,
                'alamat' => $this->input->post('alamat', true),
                'kontak' => $this->input->post('kontak', true),
                'email' => $this->input->post('email', true),
                'latitude' => $this->input->post('latitude', true),
                'longitude' => $this->input->post('longitude', true),
                'deskripsi' => $this->input->post('deskripsi', true),
            ];

            $this->Polres_model->add($data);
            redirect('polres');
        }
    }

    public function update($id)
    {
        $this->form_validation->set_rules(
            'nama_polres',
            'Nama Polres',
            'required|trim',
            array(
                'required' => 'Kolom Nama Polres Tidak Boleh Kosong',
                'is_unique' => 'Nama Polres $s Sudah Terpakai'
            )
        );
        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'required|trim',
            array(
                'required' => 'Kolom Alamat Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'kontak',
            'Kontak',
            'required|trim',
            array(
                'required' => 'Kolom Kontak Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim',
            array(
                'required' => 'Kolom Email Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'latitude',
            'Latitude',
            'required|trim',
            array(
                'required' => 'Kolom Latitude Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'longitude',
            'Longitude',
            'required|trim',
            array(
                'required' => 'Kolom Longitude Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'deskripsi',
            'Deskripsi',
            'required|trim',
            array(
                'required' => 'Kolom Deskripsi Tidak Boleh Kosong',
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $data['polres'] = $this->Polres_model->getid($id);
            $data['user'] = $this->Polres_model->dashboard();
            $data['map'] = $this->Polres_model->map();
            $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
            $data['title'] = 'Halaman Tambah Polres';
            $this->load->view('template/head', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/header', $data);
            $this->load->view('user/polres_edit', $data);
            $this->load->view('template/footer');
            $this->load->view('user/fungsi_polres_add', $data);
            $this->load->view('user/fungsi_map', $data);
        } else {
            $upload_file = $_FILES['file_image']['name'];
            if ($upload_file) {

                $config['upload_path']      = './assets/file_upload/';
                $config['allowed_types']    = 'jpeg|jpg|png';
                $config['max_size']         = '5000';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file_image')) {
                    $old_file = $data['update']['file_image'];
                    if ($old_file != $upload_file) {
                        unlink(FCPATH . 'assets/file_upload/' . $old_file);
                    }
                    $new_file = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                }
            } else {
                $new_file = $data['update']['file_image'];
            }

            $data = [
                'nama_polres' => $this->input->post('nama_polres', true),
                'gambar' => $new_file,
                'alamat' => $this->input->post('alamat', true),
                'kontak' => $this->input->post('kontak', true),
                'email' => $this->input->post('email', true),
                'latitude' => $this->input->post('latitude', true),
                'longitude' => $this->input->post('longitude', true),
                'deskripsi' => $this->input->post('deskripsi', true),
            ];


            $this->Polres_model->update($data);
            $this->session->set_flashdata('message', 'Data Telah Berhasil Diupdate');
            redirect('polres');
        }
    }

    // Function Delete Data
    public function delete($id)
    {
        $this->Polres_model->delete($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('polres');
    }

    public function showmap()
    {
        $data['map'] = $this->Polres_model->map();
        $data['user'] = $this->Polres_model->dashboard();
        $data['nilaiMax'] = $this->Polres_model->nilaiMax();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Polres';
        $fileName = base_url('assets/user/vendors/geojson/jogja.geojson');
        $file = file_get_contents($fileName);
        $file = json_decode($file);

        $data['geojson'] = $file->features;
        $i = 1;
        foreach ($data['geojson'] as $index => $feature) {
            $region = $feature->properties->region;
            $query = $this->db->select('*, sum(jumlah_kejahatan) as nilai, tb_data_kejahatan.id_kabupaten as id_kab')
                ->from('tb_data_kejahatan')
                ->join('tb_kabupaten', 'tb_data_kejahatan.id_kabupaten = tb_kabupaten.id_kabupaten', 'left')
                ->join('tb_kejahatan', 'tb_data_kejahatan.id_kejahatan = tb_kejahatan.id_kejahatan', 'left')
                ->where('kabupaten', $region)
                ->group_by('id_kab')
                ->get()->row_array();
            // ->get()->row_array();
            // print_r($query['nilai']);exit();
            if ($query) {
                $data['geojson'][$index]->properties->nilai = $query['nilai'];
            }
            $i++;
        }


        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('user/showmap', $data);
        $this->load->view('template/footer');
        $this->load->view('user/fungsi_showmap', $data);
        $this->load->view('user/fungsi_map', $data);
    }

    public function searchmap()
    {
        $tahun = $this->input->post('tahun', true);
        $bulan = $this->input->post('bulan', true);
        $fileName = base_url('assets/user/vendors/geojson/jogja.geojson');
        $file = file_get_contents($fileName);
        $file = json_decode($file);

        $data['geojson'] = $file->features;
        $i = 1;
        foreach ($data['geojson'] as $index => $feature) {
            $region = $feature->properties->region;
            $query = $this->db->select('*, IFNULL(SUM(jumlah_kejahatan), 0) as nilai, tb_data_kejahatan.id_kabupaten as id_kab')
                ->from('tb_data_kejahatan')
                ->join('tb_kabupaten', 'tb_data_kejahatan.id_kabupaten = tb_kabupaten.id_kabupaten', 'left')
                ->join('tb_kejahatan', 'tb_data_kejahatan.id_kejahatan = tb_kejahatan.id_kejahatan', 'left')
                ->where('kabupaten', $region)
                ->like('tgl_kejadian', $tahun)
                ->like('tgl_kejadian', $bulan)
                ->group_by('id_kab')
                ->get()->row_array();
            // ->get()->row_array();
            // print_r($query['nilai']);exit();
            // if($query->num_rows() < 1) {
            //     $query['nilai'] = '0';
            // }

            if ($query) {
                $data['geojson'][$index]->properties->nilai = $query['nilai'];
            } else {
                $data['geojson'][$index]->properties->nilai = 0;
            }
            $i++;
        }
        // print_r($geojson); exit();
        $max = $this->db->select('IFNULL(MAX(jumlah_kejahatan), 0) as max')
            ->from('tb_data_kejahatan')
            ->like('tgl_kejadian', $tahun)
            ->like('tgl_kejadian', $bulan)
            ->get()->row_array();
        // $data['test'] = "12";
        $data = [
            'geojson' => $data['geojson'],
            'nilaiMax' => $max,
        ];

        echo json_encode($data);
    }
}
