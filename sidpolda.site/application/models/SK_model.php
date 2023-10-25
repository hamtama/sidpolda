<?php
class SK_model extends CI_Model
{

    public function dashboard()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_role', 'users.id_role = user_role.id_role');
        $this->db->where('username', $this->session->userdata('username'));
        return $this->db->get()->row_array();
    }
    // query select all surat keluar
    public function show_sk()
    {
        return $this->db->get('tb_surat_keluar')->result_array();
    }

    // query insert surat keluar
    public function add_surat_keluar($data)
    {
        $this->db->insert('tb_surat_keluar', $data);
    }

    // combo box perihal
    public function show_perihal()
    {
        return $this->db->get('tb_perihal')->result_array();
    }

    // query update data surat keluar
    public function update_sk($data)
    {
        $id = $this->input->post('id', true);

        $this->db->where('id_surat_keluar', $id);
        $this->db->update('tb_surat_keluar', $data);
    }

    // query delete sub menu
    public function delete_sk($id)
    {
        $this->db->where('id_surat_keluar', $id);
        $this->db->delete('tb_surat_keluar');
    }


    function getUsers($postData = null)
    {
        $response = array();

        ## Read Value

        $draw = $postData['draw'];
        $start = isset($postData['start']) ? $postData['start'] : 0;
        $rowperpage = isset($postData['length']) ? $postData['length'] : 10; //Row display per page
        $columnIndex = isset($postData['order'][0]['column']) ? $postData['order'][0]['column'] : 0;
        $columnName = isset($postData['columns'][$columnIndex]['data']) ? $postData['columns'][$columnIndex]['data'] : "nomor";
        $columnSortOrder = isset($postData['order'][0]['dir']) ? $postData['order'][0]['dir'] : "asc";
        $searchValue = isset($postData['search']['value']) ? $postData['search']['value'] : '';

        // Custom search filter
        $searchPerihal = isset($postData['searchPerihal']) ? $postData['searchPerihal'] : '';
        $searchBulan = isset($postData['searchBulan']) ? $postData['searchBulan'] : '';
        $searchTahun = isset($postData['searchTahun']) ? $postData['searchTahun'] : '';

        #Search
        $search_arr = array();
        $searchQuery = "";
        if ($searchValue != "") {
            $search_arr[] = "id_perihal like '%" . $searchValue . "%' OR tb_surat_keluar.tgl_surat like '%" . $searchValue . "%' OR tb_dl_sk.tanggal like '%" . $searchValue . "%')";
        }
        if ($searchPerihal != '') {
            $search_arr[] = "id_perihal like  '%" . $searchPerihal . "%'";
        }
        if ($searchBulan != '') {
            $search_arr[] = "tb_surat_keluar.tgl_surat like  '%" . $searchBulan . "%'";
        }
        if ($searchTahun != '') {
            $search_arr[] = "tb_surat_keluar.tgl_surat like  '%" . $searchTahun . "%'";
        }
        if (count($search_arr) > 0) {
            $searchQuery = implode(" and ", $search_arr);
        }

        ## Total number of record without filtering
        $this->db->select('*, count(*) as allcount , tb_dis_sk.tanggal AS tgl, tb_dis_sk.keterangan AS ket, tb_dl_sk.id_surat_keluar as id_surat');
        $this->db->from('tb_surat_keluar');
        $this->db->join('tb_dl_sk', 'tb_surat_keluar.id_surat_keluar = tb_dl_sk.id_surat_keluar', 'left');
        $this->db->join('tb_dis_sk', 'tb_surat_keluar.id_surat_keluar = tb_dis_sk.id_surat_keluar', 'left');
        $this->db->join('tb_perihal', 'tb_surat_keluar.perihal = tb_perihal.id_perihal', 'left');
        $this->db->join('tb_status', 'tb_surat_keluar.status = tb_status.id_status', 'left');
        $records =  $this->db->get()->result();

        $totalRecords = $records[0]->allcount;

        ## Total number o record with filtering
        $this->db->select(' *, count(*) as allcount  ');
        $this->db->from('tb_surat_keluar');
        $this->db->join('tb_dl_sk', 'tb_surat_keluar.id_surat_keluar = tb_dl_sk.id_surat_keluar', 'left');
        $this->db->join('tb_dis_sk', 'tb_surat_keluar.id_surat_keluar = tb_dis_sk.id_surat_keluar', 'left');
        $this->db->join('tb_perihal', 'tb_surat_keluar.perihal = tb_perihal.id_perihal', 'left');
        $this->db->join('tb_status', 'tb_surat_keluar.status = tb_status.id_status', 'left');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ##Fetch Records
        $this->db->select(' *, (ROW_NUMBER() OVER (Order by tb_dl_sk.id_surat_keluar)) as nomor, tb_dl_sk.id_surat_keluar as id_surat, tb_dis_sk.tanggal AS tgl, tb_dis_sk.keterangan AS ket');
        $this->db->from('tb_surat_keluar');
        $this->db->join('tb_dl_sk', 'tb_surat_keluar.id_surat_keluar = tb_dl_sk.id_surat_keluar', 'left');
        $this->db->join('tb_dis_sk', 'tb_surat_keluar.id_surat_keluar = tb_dis_sk.id_surat_keluar', 'left');
        $this->db->join('tb_perihal', 'tb_surat_keluar.perihal = tb_perihal.id_perihal', 'left');
        $this->db->join('tb_status', 'tb_surat_keluar.status = tb_status.id_status', 'left');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();

        $data = array();

        foreach ($records as $record) {
            $data[] = array(
                "nomor" => $record->nomor,
                "no_surat_keluar" => $record->no_surat_keluar,
                "id_surat_keluar" => $record->id_surat_keluar,
                "id_surat" => $record->id_surat,
                "tgl_surat" => $record->tgl_surat,
                "tujuan" => $record->tujuan,
                "perihal" => $record->perihal,
                "warna" => $record->warna,
                "status" => $record->status,
                "id_status" => $record->id_status,
                "file_sk" => $record->file_sk,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        return $response;
    }

    function cetak_data()
    {
        $id = $this->input->post('id', true);
        $this->db->select('* , tb_dis_sk.tanggal AS tgl_dis, tb_dl_sk.id_surat_keluar as id_surat, tb_dis_sk.keterangan AS ket_dis, tb_dl_sk.id_surat_keluar as id_surat, tb_dl_sk.tanggal AS tgl_dl, tb_dl_sk.keterangan AS ket_dl');
        $this->db->from('tb_surat_keluar');
        $this->db->join('tb_dl_sk', 'tb_surat_keluar.id_surat_keluar = tb_dl_sk.id_surat_keluar', 'left');
        $this->db->join('tb_dis_sk', 'tb_surat_keluar.id_surat_keluar = tb_dis_sk.id_surat_keluar', 'left');
        $this->db->join('tb_perihal', 'tb_surat_keluar.perihal = tb_perihal.id_perihal', 'left');
        $this->db->join('tb_status', 'tb_surat_keluar.status = tb_status.id_status', 'left');
        $this->db->where('tb_surat_keluar.id_surat_keluar', $id);
        $data =   $this->db->get()->row_array();
        return $data;
    }
}
