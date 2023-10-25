<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class SM_model extends CI_Model
{

    public function dashboard()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_role', 'users.id_role = user_role.id_role');
        $this->db->where('username', $this->session->userdata('username'));
        return $this->db->get()->row_array();
    }
    // query select all surat masuk
    public function show_sm()
    {
        return $this->db->get('tb_surat_masuk')->result_array();
    }

    // query insert surat masuk
    public function add_surat_masuk($data)
    {
        $this->db->insert('tb_surat_masuk', $data);
    }

    // combo box perihal
    public function show_perihal()
    {
        return $this->db->get('tb_perihal')->result_array();
    }

    // query update data surat masuk
    public function update_sm($data)
    {
        $id = $this->input->post('id', true);

        $this->db->where('id_surat_masuk', $id);
        $this->db->update('tb_surat_masuk', $data);
    }

    // query delete sub menu
    public function delete_sm($id)
    {
        $this->db->where('id_surat_masuk', $id);
        $this->db->delete('tb_surat_masuk');
    }



    // ================================ FILTER DATA =======================================

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
            $search_arr[] = "id_perihal like '%" . $searchValue . "%' OR tb_surat_masuk.tgl_surat like '%" . $searchValue . "%' OR tb_dl_sm.tanggal like '%" . $searchValue . "%')";
        }
        if ($searchPerihal != '') {
            $search_arr[] = "id_perihal like  '%" . $searchPerihal . "%'";
        }
        if ($searchBulan != '') {
            $search_arr[] = "tb_surat_masuk.tgl_surat like  '%" . $searchBulan . "%'";
        }
        if ($searchTahun != '') {
            $search_arr[] = "tb_surat_masuk.tgl_surat like  '%" . $searchTahun . "%'";
        }
        if (count($search_arr) > 0) {
            $searchQuery = implode(" and ", $search_arr);
        }

        ## Total number of record without filtering
        $this->db->select('*, count(*) as allcount , tb_dis_sm.tanggal AS tgl, tb_dis_sm.keterangan AS ket, tb_dl_sm.id_surat_masuk as id_surat');
        $this->db->from('tb_surat_masuk');
        $this->db->join('tb_dl_sm', 'tb_surat_masuk.id_surat_masuk = tb_dl_sm.id_surat_masuk', 'left');
        $this->db->join('tb_dis_sm', 'tb_surat_masuk.id_surat_masuk = tb_dis_sm.id_surat_masuk', 'left');
        $this->db->join('tb_perihal', 'tb_surat_masuk.perihal = tb_perihal.id_perihal', 'left');
        $this->db->join('tb_status', 'tb_surat_masuk.status = tb_status.id_status', 'left');
        $records =  $this->db->get()->result();

        $totalRecords = $records[0]->allcount;

        ## Total number o record with filtering
        $this->db->select('*, count(*) as allcount');
        $this->db->from('tb_surat_masuk');
        $this->db->join('tb_dl_sm', 'tb_surat_masuk.id_surat_masuk = tb_dl_sm.id_surat_masuk', 'left');
        $this->db->join('tb_dis_sm', 'tb_surat_masuk.id_surat_masuk = tb_dis_sm.id_surat_masuk', 'left');
        $this->db->join('tb_perihal', 'tb_surat_masuk.perihal = tb_perihal.id_perihal', 'left');
        $this->db->join('tb_status', 'tb_surat_masuk.status = tb_status.id_status', 'left');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ##Fetch Records
        $this->db->select('*, (ROW_NUMBER() OVER (Order by tb_dl_sm.id_surat_masuk)) as nomor ,tb_dl_sm.id_surat_masuk as id_surat, tb_dis_sm.tanggal AS tgl, tb_dis_sm.keterangan AS ket');
        $this->db->from('tb_surat_masuk');
        $this->db->join('tb_dl_sm', 'tb_surat_masuk.id_surat_masuk = tb_dl_sm.id_surat_masuk', 'left');
        $this->db->join('tb_dis_sm', 'tb_surat_masuk.id_surat_masuk = tb_dis_sm.id_surat_masuk', 'left');
        $this->db->join('tb_perihal', 'tb_perihal.id_perihal = tb_surat_masuk.perihal', 'left');
        $this->db->join('tb_status', 'tb_status.id_status = tb_surat_masuk.status', 'left');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();

        $data = array();

        foreach ($records as $record) {
            $data[] = array(
                "nomor" => $record->nomor,
                "id_surat_masuk" => $record->id_surat_masuk,
                "no_surat_masuk" => $record->no_surat_masuk,
                "id_surat" => $record->id_surat,
                "tgl_surat" => $record->tgl_surat,
                "asal_surat" => $record->asal_surat,
                "perihal" => $record->perihal,
                "warna" => $record->warna,
                "status" => $record->status,
                "file_sm" => $record->file_sm,
                "id_status" => $record->id_status
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
        $this->db->select('*, tb_dis_sm.tanggal AS tgl_dis, tb_dl_sm.id_surat_masuk as id_surat, tb_dis_sm.keterangan AS ket_dis, tb_dl_sm.tanggal AS tgl_dl, tb_dl_sm.keterangan AS ket_dl');
        $this->db->from('tb_surat_masuk');
        $this->db->join('tb_dl_sm', 'tb_surat_masuk.id_surat_masuk = tb_dl_sm.id_surat_masuk', 'left');
        $this->db->join('tb_dis_sm', 'tb_surat_masuk.id_surat_masuk = tb_dis_sm.id_surat_masuk', 'left');
        $this->db->join('tb_perihal', 'tb_surat_masuk.perihal = tb_perihal.id_perihal', 'left');
        $this->db->join('tb_status', 'tb_surat_masuk.status = tb_status.id_status', 'left');
        $this->db->where('tb_surat_masuk.id_surat_masuk', $id);
        $data =   $this->db->get()->row_array();
        return $data;
    }
}
