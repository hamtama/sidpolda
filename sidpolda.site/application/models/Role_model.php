<?php
class Role_model extends CI_Model
{
    public function dashboard()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_role', 'users.id_role = user_role.id_role');
        $this->db->where('username', $this->session->userdata('username'));
        return $this->db->get()->row_array();
    }
    public function show_menu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    public function select_role()
    {
        return $this->db->get('user_role')->result_array();
    }

    public function add_role()
    {
        $data = [
            'role'  => $this->input->post('role', true),
        ];
        $this->db->insert('user_role', $data);
    }

    public function update_role()
    {
        $id = $this->input->post('id', true);
        $data = [
            'role'  => $this->input->post('role', true),
        ];
        $this->db->where('id_role', $id);
        $this->db->update('user_role', $data);
    }

    public function delete_role($id_role)
    {
        $this->db->where('id_role', $id_role);
        $this->db->delete('user_role');
    }


    public function aktifasi_menu()
    {
        $data = [
            'id_menu'  => $this->input->post('id_menu', true),
            'id_role' => $this->input->post('id_role', true),
        ];

        $this->db->insert('user_access_menu', $data);
    }


    public function deaktifasi_menu()
    {
        $id_menu = $this->input->post('id_menu', true);
        $id_role = $this->input->post('id_role', true);
        $this->db->where('id_menu', $id_menu);
        $this->db->where('id_role', $id_role);
        $this->db->delete('user_access_menu');
    }
}
