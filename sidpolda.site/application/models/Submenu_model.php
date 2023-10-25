<?php
class Submenu_model extends CI_Model
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
    public function add_submenu()
    {
        $data = [
            'id_menu'  => $this->input->post('menu', true),
            'title' => $this->input->post('title', true),
            'url' => $this->input->post('url', true),
            'is_active' => $this->input->post('aktif', true),
        ];
        $this->db->insert('user_sub_menu', $data);
    }
    public function update_submenu()
    {
        $id = $this->input->post('id', true);
        $data = [
            'id_menu'  => $this->input->post('menu', true),
            'title' => $this->input->post('title', true),
            'url' => $this->input->post('url', true),
            'is_active' => $this->input->post('aktif', true),
        ];
        $this->db->where('id_sub_menu', $id);
        $this->db->update('user_sub_menu', $data);
    }
    public function aktifasi_submenu()
    {
        $id = $this->input->post('id', true);
        $data = [
            'is_active' => $this->input->post('isi', true),
        ];
        $this->db->where('id_sub_menu', $id);
        $this->db->update('user_sub_menu', $data);
    }
    public function delete_submenu($id)
    {
        $this->db->where('id_sub_menu', $id);
        $this->db->delete('user_sub_menu');
    }
}
