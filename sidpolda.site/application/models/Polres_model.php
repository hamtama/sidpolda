<?php
class Polres_model extends CI_Model
{
    public function dashboard()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_role', 'users.id_role = user_role.id_role');
        $this->db->where('username', $this->session->userdata('username'));
        return $this->db->get()->row_array();
    }

    public function map()
    {
        $this->db->select(" *, replace(nama_polres, ' ', '') AS name");
        $this->db->from("tb_polres");
        return $this->db->get()->result_array();
    }

    public function nilaiMax()
    {
        $this->db->select('MAX(jumlah_kejahatan) as nilai')
            ->from('tb_data_kejahatan');
        return $this->db->get()->result_array();
    }

    public function add($data)
    {

        $this->db->insert('tb_polres', $data);
    }
    public function getid($id)
    {
        return $this->db->get_where('tb_polres', ['id_polres' => $id])->row_array();
    }

    public function update($data)
    {
        $id = $this->input->post('id', true);
        $this->db->where('id_polres', $id);
        $this->db->update('tb_polres', $data);
    }


    public function delete($id)
    {
        $this->db->where('id_polres', $id);
        $this->db->delete('tb_polres');
    }
}
