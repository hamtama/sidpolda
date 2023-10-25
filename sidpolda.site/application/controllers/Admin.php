<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model"); //load model mahasiswa
    }

    public function index()
    {
        // $user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        if ($this->session->userdata('logged') != TRUE) {
            if ($this->session->userdata('id_role') == 1) {
                $this->db->select('*');
                $this->db->from('users');
                $this->db->join('user_role', 'users.id_role = user_role.id_role');
                $this->db->where('username', $this->session->userdata('username'));
                $data['user'] = $this->db->get()->row_array();
                $data['show_kejahatan'] = $this->Admin_model->show_kejahatan();
                $data['sum_kejahatan'] = $this->Admin_model->sum_kejahatan();
                $data['sum_kejahatan_cc'] = $this->Admin_model->sum_kejahatan_cc();
                $data['kabupaten'] = $this->Admin_model->kabupaten();
                $data['title'] = 'Halaman Administrator';
                $this->load->view('template/head', $data);
                $this->load->view('template/sidebar', $data);
                $this->load->view('template/header', $data);
                $this->load->view('administrator/index', $data);
                $this->load->view('template/footer');
                $this->load->view('administrator/fungsi_i', $data);
            } else {
                redirect('user');
            }
        } else {
            redirect('auth');
        };
    }

    public function searchgraph()
    {
        $periode = $this->input->post('update', true);
        $select = $this->input->post('select', true);
        if (isset($periode) && ($select)) {
            $where = "'%" . $periode . "%'";
        } else {
            $where = "'%2022%'";
        }


        $data['data_kejahatan'] = $this->db->query("SELECT id_kej, kejahatan, warna, warna_cc, IFNULL(sum_total, 0) AS total, IFNULL(sum_total_cc, 0) AS total_cc
        FROM (
            SELECT id_kej, kejahatan, warna, warna_cc, 
                SUM(CASE WHEN jumlah_kejahatan IS NOT NULL AND b_date LIKE $where THEN jumlah_kejahatan ELSE 0 END) AS sum_total, 
                SUM(CASE WHEN jumlah_cc IS NOT NULL AND c_date LIKE $where THEN jumlah_cc ELSE 0 END) AS sum_total_cc
            FROM (
                SELECT a.id_kejahatan AS id_kej, kejahatan, warna, warna_cc, jumlah_kejahatan, jumlah_cc, b.tgl_kejadian AS b_date, c.tgl_kejadian AS c_date
                FROM tb_kejahatan a
                LEFT JOIN tb_data_kejahatan b ON a.id_kejahatan = b.id_kejahatan
                LEFT JOIN tb_data_cc c ON a.id_kejahatan = c.id_kejahatan
            ) sub
            GROUP BY id_kej, kejahatan, warna, warna_cc
        ) sub_total")->result_array();
        // print_r($where);


        $i = 1;
        $c = count($data['data_kejahatan']);
        // print_r($c);
        $kejahatan = "";
        $warna = "";
        $warna_cc = "";
        $total = "";
        $total_cc = "";
        foreach ($data['data_kejahatan'] as $row) {
            if ($i < $c) {
                $kejahatan .= $row['kejahatan'] . ',';
                $warna .= $row['warna'] . ',';
                $total .= $row['total'] . ',';
                $warna_cc .= $row['warna_cc'] . ',';
                $total_cc .= $row['total_cc'] . ',';
            } else {
                $kejahatan .= $row['kejahatan'];
                $warna .= $row['warna'];
                $total .= $row['total'];
                $warna_cc .= $row['warna_cc'];
                $total_cc .= $row['total_cc'];
            }
            $i++;
        }

        $sum =  $this->db->select('IFNULL(sum(jumlah_kejahatan), 0) as nilai')
            ->from('tb_data_kejahatan')
            ->like('tgl_kejadian', $periode)
            ->get()->row_array();
        $sum_cc =  $this->db->select('IFNULL(sum(jumlah_cc), 0) as nilai')
            ->from('tb_data_cc')
            ->like('tgl_kejadian', $periode)
            ->get()->row_array();

        $data = [
            'kejahatan' => $kejahatan,
            'warna' => $warna,
            'warna_cc' => $warna_cc,
            'total' => $total,
            'total_cc' => $total_cc,
            'sum' => $sum,
            'sum_cc' => $sum_cc,
        ];
        echo json_encode($data);
    }

    public function graphmonth()

    {
        $thn = $this->input->post('thn', true);
        $bln = $this->input->post('thn', true);
        $kab = $this->input->post('kab', true);
        if (isset($thn) || ($kab)) {
            $thn = $thn;
            $kab = $kab;
        } else {
            $thn = "2022";
            $kab = "";
        }

        $month = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];

        $query_kej = $this->db->select('*')
            ->from('tb_kejahatan')
            ->get()->result_array();
        $b = 1;
        foreach ($query_kej as $row1) {
            $dt['id_kejahatan'][$b] = $row1['id_kejahatan'];
            $dt['kejahatan'][$b] = $row1['kejahatan'];
            $dt['warna'][$b] = $row1['warna'];
            $dt['hasil'][$b] = '';
            $b++;
        }
        // print_r($data);
        $max_kej = $this->db->count_all('tb_kejahatan');


        for ($a = 1; $a <= $max_kej; $a++) {
            // print_r(count($month));exit;
            for ($d = 0; $d < 12; $d++) {
                // $tahun = $this->input->post('tahun', true);
                $query = $this->db->select("*, sum(jumlah_kejahatan) as jumlah, warna")
                    ->from('tb_data_kejahatan as a')
                    ->join('tb_kejahatan as b', 'a.id_kejahatan = b.id_kejahatan', 'left')
                    ->join('tb_kabupaten as c', 'a.id_kabupaten = c.id_kabupaten', 'left')
                    ->where('(DATE_FORMAT(tgl_kejadian, "%m") = "' . $month[$d] . '")')
                    ->where('a.id_kejahatan', $dt['id_kejahatan'][$a])
                    ->like('a.id_kabupaten', $kab)
                    ->like('tgl_kejadian', $thn)
                    ->group_by('kejahatan');
                $row = $query->get()->row_array();
                // print_r($row);

                if ($row > 0) {
                    $dt['nilai'][$d] = $row['jumlah'];
                } else {
                    $dt['nilai'][$d] = '0';
                }

                // echo $dt['hasil'][$a];
                if ($d < 11) {
                    $dt['hasil'][$a] .= $dt['nilai'][$d] . ',';
                } else {
                    $dt['hasil'][$a] .= $dt['nilai'][$d];
                }
                // echo $dt['id_kejahatan'][$a];
                // echo $dt['nilai'][$a];
            }
            // echo $month[$d];


            $data[$a] = [
                'kejahatan' => $dt['kejahatan'][$a],
                'warna' => $dt['warna'][$a],
                'nilai' => $dt['hasil'][$a]
            ];
        }

        // $dt['kejahatan' . ] = $data['kejahatan'][$a];
        // $dt['warna' . $a] = $data['warna'][$a];
        // $dt['nilai' . $a] = $data['nilai'][$a];

        echo json_encode($data);
        // print_r($dt);
    }
}
