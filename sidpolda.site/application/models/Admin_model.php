<?php
class Admin_model extends CI_Model
{
    public function show_kejahatan()
    {
        $query = $this->db->query("SELECT id_kej, kejahatan, warna, warna_cc, IFNULL(sum_total, 0) AS total, IFNULL(sum_total_cc, 0) AS total_cc
        FROM (
            SELECT id_kej, kejahatan, warna, warna_cc, 
                SUM(CASE WHEN jumlah_kejahatan IS NOT NULL AND b_date LIKE '%2022-12%' THEN jumlah_kejahatan ELSE 0 END) AS sum_total, 
                SUM(CASE WHEN jumlah_cc IS NOT NULL AND c_date LIKE '%2022-12%' THEN jumlah_cc ELSE 0 END) AS sum_total_cc
            FROM (
                SELECT a.id_kejahatan AS id_kej, kejahatan, warna, warna_cc, jumlah_kejahatan, jumlah_cc, b.tgl_kejadian AS b_date, c.tgl_kejadian AS c_date
                FROM tb_kejahatan a
                LEFT JOIN tb_data_kejahatan b ON a.id_kejahatan = b.id_kejahatan
                LEFT JOIN tb_data_cc c ON a.id_kejahatan = c.id_kejahatan
            ) sub
            GROUP BY id_kej, kejahatan, warna, warna_cc
        ) sub_total");

        return $query->result_array();
    }
    public function kabupaten()
    {
        return $this->db->get('tb_kabupaten')->result_array();
    }

    public function sum_kejahatan()
    {
        $this->db->select('*, sum(jumlah_kejahatan) as total');
        $this->db->from('tb_data_kejahatan');
        $this->db->group_by('id_kejahatan');
        $this->db->order_by('id_kejahatan');
        return $this->db->get()->result_array();
    }
    public function sum_kejahatan_cc()
    {
        $this->db->select('*, sum(jumlah_cc) as total');
        $this->db->from('tb_data_cc');
        $this->db->group_by('id_kejahatan');
        $this->db->order_by('id_kejahatan');
        return $this->db->get()->result_array();
    }
}
