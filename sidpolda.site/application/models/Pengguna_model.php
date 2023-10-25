<?php
class Pengguna_model extends CI_Model
{
    public function dashboard()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_role', 'users.id_role = user_role.id_role');
        $this->db->where('username', $this->session->userdata('username'));
        return $this->db->get()->row_array();
    }

    public function show_role()
    {
        return $this->db->get('user_role')->result_array();
    }
    public function aktifasi_user()
    {
        $id = $this->input->post('id', true);
        $data = [
            'active' => $this->input->post('isi', true),
        ];
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }


    public function add_user()
    {
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
            'active'    => '0',
        ];

        $this->db->insert('users', $data);
    }

    public function update_user($data)
    {
        $id = $this->input->post('id', true);
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    public function delete_user($id_user)
    {
        $this->db->where('id', $id_user);
        $this->db->delete('users');
    }
}
