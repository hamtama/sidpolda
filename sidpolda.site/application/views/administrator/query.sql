SELECT id_kej, kejahatan, warna, warna_cc, ifnull(sum(sum_total), 0) as total , ifnull(sum(sum_total_cc), 0) as total_cc FROM (
    select  id_kej, kejahatan, warna, warna_cc,
    CASE WHEN jumlah_kejahatan IS NOT NULL AND  b_date like '%2022-12%' THEN SUM(jumlah_kejahatan) END sum_total,
    CASE WHEN jumlah_cc IS NOT NULL AND  c_date like '%2022-12%' THEN SUM(jumlah_cc) end sum_total_cc
    from ( 
        select a.id_kejahatan as id_kej, kejahatan, warna, warna_cc, jumlah_kejahatan , jumlah_cc, b.tgl_kejadian as b_date, c.tgl_kejadian as c_date
        from tb_kejahatan a 
        inner join tb_data_kejahatan b on b.id_kejahatan = a.id_kejahatan
        INNER JOIN tb_data_cc c on c.id_kejahatan = c.id_kejahatan
    ) sub
    group by kejahatan, c_date, b_date
) subq2
group by kejahatan
ORDER BY id_kej DESC



 // $data['clear_crime'] = $this->db->select('*, sum(jumlah_cc) as total_cc')
        //     ->from('tb_data_cc a')
        //     ->join('tb_kejahatan b', 'a.id_kejahatan = b.id_kejahatan', 'left')
        //     ->join('tb_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left')
        //     ->like('tgl_kejadian', $tahun)
        //     ->like('tgl_kejadian', $bulan)
        //     ->group_by('kejahatan')
        //     ->order_by('b.id_kejahatan')
        //     ->get()->result_array();

        // $data['data_kejahatan'] = $this->db->select('*, sum(jumlah_kejahatan) as total ')
        //     ->from('tb_data_kejahatan a')
        //     ->join('tb_kejahatan b', 'a.id_kejahatan = b.id_kejahatan', 'left')
        //     ->join('tb_kabupaten c', 'a.id_kabupaten = c.id_kabupaten', 'left')
        //     ->like('tgl_kejadian', $tahun)
        //     ->like('tgl_kejadian', $bulan)
        //     ->group_by('kejahatan')
        //     ->order_by('b.id_kejahatan')
        //     ->get()->result_array();