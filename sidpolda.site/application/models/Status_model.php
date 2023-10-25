<?php
class Status_model extends CI_Model
{
    public function dashboard()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_role', 'users.id_role = user_role.id_role');
        $this->db->where('username', $this->session->userdata('username'));
        return $this->db->get()->row_array();
    }

    public function add_status()
    {
        $data = [
            'status'  => $this->input->post('status', true),
            'warna'  => $this->input->post('warna', true),
        ];

        $this->db->insert('tb_status', $data);
    }
    // 
    public function update_status()
    {
        $id = $this->input->post('id', true);
        $data = [
            'status'  => $this->input->post('status', true),
            'warna'  => $this->input->post('warna', true),

        ];
        $this->db->where('id_status', $id);
        $this->db->update('tb_status', $data);
    }

    public function delete_status($id_status)
    {
        $this->db->where('id_status', $id_status);
        $this->db->delete('tb_status');
    }
}
