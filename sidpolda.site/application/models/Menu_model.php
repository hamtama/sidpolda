<?php
class Menu_model extends CI_Model
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

    public function select_menu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    public function add_menu()
    {
        $data = [
            'menu'  => $this->input->post('menu', true),
            'icon' => $this->input->post('ikon', true),
            'urutan' => $this->input->post('urutan', true),
            // 'is_active' => '0'
        ];

        $this->db->insert('user_menu', $data);
    }
    // 
    public function update_menu()
    {
        $id = $this->input->post('id', true);
        $data = [
            'menu'  => $this->input->post('menu', true),
            'icon' => $this->input->post('ikon', true),
            'urutan' => $this->input->post('urutan', true),
        ];
        $this->db->where('id_menu', $id);
        $this->db->update('user_menu', $data);
    }

    public function delete_menu($id_menu)
    {
        $this->db->where('id_menu', $id_menu);
        $this->db->delete('user_menu');
    }
    public function aktifasi_menu()
    {
        $id = $this->input->post('id', true);
        $data = [
            'is_active' => $this->input->post('isi', true),
        ];
        $this->db->where('id_menu', $id);
        $this->db->update('user_menu', $data);
    }
}
