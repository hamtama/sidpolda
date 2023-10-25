<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        // check_login();
    }

    public function index()
    {
        $user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        if ($this->session->userdata('logged') != TRUE) {
            if (isset($user['id_role']) && $user['id_role'] == 1) {
                redirect('admin');
            }
        } else {
            redirect('auth');
        };
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
            'required|trim|min_length[6]',
            array(
                'required' => 'Kolom Password Tidak Boleh Kosong',
                'min_length'    => 'Password Terlalu Pendek, Minimal 6 Karakter'
            )
        );

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('template/auth_head', $data);
            $this->load->view('auth/login');
            $this->load->view('template/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('users', ['username' => $username])->row_array();

        if ($user) {
            if ($user['active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'username' => $user['username'],
                        'id_role' => $user['id_role'],
                    ];
                    $this->session->set_userdata($data);
                    if ($user['id_role'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Password Salah</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Username Belum Diaktifasi</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Username Tidak Terdaftar</div>');
            redirect('auth');
        }
    }


    public function registration()
    {
        $data['title'] = 'Regitration Page';
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
            // $data[check]
            $this->load->view('template/auth_head', $data);
            $this->load->view('auth/register');
            $this->load->view('template/auth_footer');
        } else {
            // $this->load->view()
            $data = [
                'nama'  => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'username' => $this->input->post('username'),
                'image' => 'default.jpg',
                'password' => password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                ),
                'id_role'   => 4,
                'active'    => '0',
            ];

            $this->db->insert('users', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Registrasi Telah Berhasil</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('id_role');

        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Kamu Berhasil Logout</div>');
        redirect('auth');
    }

    public function blocked()
    {
        // echo "gagal";
        $this->load->view('auth/blocker');
    }
}
