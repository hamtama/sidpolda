<?php
class Kabupaten_model extends CI_Model
{
    public function dashboard()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_role', 'users.id_role = user_role.id_role');
        $this->db->where('username', $this->session->userdata('username'));
        return $this->db->get()->row_array();
    }

    public function add()
    {
        $data = [
            'kabupaten'  => $this->input->post('kabupaten', true),
        ];

        $this->db->insert('tb_kabupaten', $data);
    }
    // 
    public function update()
    {
        $id = $this->input->post('id', true);
        $data = [
            'kabupaten'  => $this->input->post('kabupaten', true),

        ];
        $this->db->where('id_kabupaten', $id);
        $this->db->update('tb_kabupaten', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_kabupaten', $id);
        $this->db->delete('tb_kabupaten');
    }
}