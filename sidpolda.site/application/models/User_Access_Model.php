<?php
class Menu_model extends CI_Model
{
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
