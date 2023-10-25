<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Pengguna_model"); //load model mahasiswa
        is_logged_in();
    }

    // Function Page Menu
    public function index()
    {
        $data['role'] = $this->Pengguna_model->show_role();
        $data['user'] = $this->Pengguna_model->dashboard();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['url' => $this->uri->segment('1')])->row_array();
        $data['title'] = 'Halaman Pengguna';
        $this->load->view('template/head', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/header', $data);
        $this->load->view('administrator/pengguna', $data);
        $this->load->view('template/footer');
        $this->load->view('administrator/fungsi_pengguna', $data);
    }

    // Function Add Data
    public function add()
    {
        $this->form_validation->set_rules(
            'nama',
            'Name',
            'required|trim',
            array(
                'required' => 'Kolom Nama Tidak Boleh Kosong'
            )
        );
        $this->form_validation->set_rules(
            'role',
            'Role',
            'required|trim',
            array(
                'required' => 'Kolom Role Tidak Boleh Kosong'
            )
        );
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email|is_unique[users.email]',
            array(
                'required' => 'Kolom Email Tidak Boleh Kosong',
                'is_unique' => 'Email %s Sudah Terpakai'
            )
        );
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim|is_unique[users.username]',
            array(
                'required' => 'Kolom Username Tidak Boleh Kosong',
                'is_unique' => 'Username %s Sudah Terpakai'
            )
        );
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|trim|min_length[6]|matches[password2]',
            array(
                'required' => 'Kolom Password Tidak Boleh Kosong',
                'matches'   => 'Password Tidak Cocok dengan Password Confirm',
                'min_length'    => 'Password Terlalu Pendek, Minimal 6 Karakter'
            )
        );
        $this->form_validation->set_rules(
            'password2',
            'Password Konfirmasi',
            'required|trim|matches[password]',
            array(
                'required' => 'Kolom Password Konfirmasi Tidak Boleh Kosong',
                'matches' => 'Password Tidak Cocok'
            )
        );

        if ($this->form_validation->run() == false) {
            $msg = [
                'input' => ['nama', 'email', 'username', 'role', 'password', 'password2'],
                'error' => [
                    'nama' => form_error('nama'),
                    'email' => form_error('email'),
                    'username' => form_error('username'),
                    'role' => form_error('role'),
                    'password' => form_error('password'),
                    'password2' => form_error('password2'),
                ]
            ];
            echo json_encode($msg);
        } else {
            $this->Pengguna_model->add_user();
        }
    }
    public function update()
    {
        $this->form_validation->set_rules(
            'nama',
            'Name',
            'required|trim',
            array(
                'required' => 'Kolom Nama Tidak Boleh Kosong'
            )
        );
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email',
            array(
                'required' => 'Kolom Email Tidak Boleh Kosong',
                'valid_email' => 'Format Email Tidak Valid',
            )
        );
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim',
            array(
                'required' => 'Kolom Username Tidak Boleh Kosong',
            )
        );
        $this->form_validation->set_rules(
            'password',
            'Password',
            'min_length[6]|matches[password2]',
            array(
                'matches'   => 'Password Tidak Cocok dengan Password Confirm',
                'min_length'    => 'Password Terlalu Pendek, Minimal 6 Karakter'
            )
        );
        $this->form_validation->set_rules(
            'password2',
            'Password Konfirmasi',
            'matches[password]',
            array(
                'matches' => 'Password Tidak Cocok'
            )
        );

        if ($this->form_validation->run() == false) {
            $msg = [
                'input' => ['nama', 'email', 'username', 'password', 'password2'],
                'error' => [
                    'nama' => form_error('nama'),
                    'email' => form_error('email'),
                    'username' => form_error('username'),
                    'password' => form_error('password'),
                    'password2' => form_error('password2'),
                ]
            ];
            echo json_encode($msg);
        } else {

            if ($this->input->post('password') != "") {
                $data = [
                    'nama'  => htmlspecialchars($this->input->post('nama', true)),
                    'email' => htmlspecialchars($this->input->post('email', true)),
                    'username' => $this->input->post('username'),
                    'image' => 'default.jpg',
                    'password' => password_hash(
                        $this->input->post('password'),
                        PASSWORD_DEFAULT
                    ),
                    'id_role'   => $this->input->post('role'),
                ];
            } elseif ($this->input->post('password') == "") {
                $data = [
                    'nama'  => htmlspecialchars($this->input->post('nama', true)),
                    'email' => htmlspecialchars($this->input->post('email', true)),
                    'username' => $this->input->post('username'),
                    'id_role'   => $this->input->post('role'),
                ];
            }
            $this->Pengguna_model->update_user($data);
        }
    }

    public function aktifasi()
    {
        $this->Pengguna_model->aktifasi_user();
    }

    // Function Delete Data
    public function delete($id)
    {
        $this->Pengguna_model->delete_user($id);
        $this->session->set_flashdata('message', 'Data Telah Berhasil Dihapus');
        redirect('pengguna');
    }

    // Function Show Data In Modal
    public function edit_select()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_role', 'users.id_role = user_role.id_role');
        $this->db->where('id', $this->input->post('id'));
        $data = $this->db->get()->row_array();
        echo json_encode($data);
    }
}
