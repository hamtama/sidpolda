<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model"); //load model mahasiswa
        $this->load->model('Polres_model');
    }

    public function index()
    {
        $data['show_kejahatan'] = $this->Admin_model->show_kejahatan();
        $data['sum_kejahatan'] = $this->Admin_model->sum_kejahatan();
        $data['sum_kejahatan_cc'] = $this->Admin_model->sum_kejahatan_cc();
        $data['kabupaten'] = $this->Admin_model->kabupaten();
        $data['title'] = 'Halaman User';
        $this->load->view('frontend/index', $data);
        $this->load->view('frontend/fungsi_i');
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



        $this->load->view('frontend/showmap', $data);
        $this->load->view('frontend/fungsi_showmap', $data);
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

    // public function index()
    // {
    //     if ($this->session->userdata('logged') != TRUE) {
    //         if ($this->session->userdata('id_role') != 1) {
    //             $this->db->select('*');
    //             $this->db->from('users');
    //             $this->db->join('user_role', 'users.id_role = user_role.id_role');
    //             $this->db->where('username', $this->session->userdata('username'));
    //             $data['user'] = $this->db->get()->row_array();
    //             $data['title'] = 'Halaman Utama';
    //             $this->load->view('template/head', $data);
    //             $this->load->view('template/sidebar', $data);
    //             $this->load->view('template/header', $data);
    //             $this->load->view('user/index', $data);
    //             $this->load->view('template/footer');
    //         } else {
    //             redirect('auth/blocked');
    //         }
    //     } else {
    //         redirect('auth');
    //     }
    // }
}
