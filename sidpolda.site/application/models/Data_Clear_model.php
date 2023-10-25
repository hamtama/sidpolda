<?php 
class Data_Clear_model extends CI_Model
{
    public function dashboard(){
        return $this->db->select('*')
        ->from('users')
        ->join('user_role', 'users.id_role = user_role.id_role')
        ->where('username', $this->session->userdata('username'))
        ->get()->row_array();
    }

    public function polres(){
        return $this->db->get('tb_polres')->result_array();
    }

    public function kabupaten() {
        return $this->db->get('tb_kabupaten')->result_array();
    }

    public function show_kejahatan()
    {
        return $this->db->get('tb_kejahatan')->result_array();
    }
    
    public function add_data_cc()
    {
        $data = [
            'tgl_kejadian' => $this->input->post('tgl_kejadian', true),
            'id_kejahatan' => $this->input->post('kejahatan', true),
            'id_kabupaten' => $this->input->post('kabupaten', true),
            'jumlah_cc' => $this->input->post('jumlah_cc', true),
            'id_polres' => $this->input->post('polres', true)
        ];
        $this->db->insert('tb_data_cc', $data);
    }

    public function update_data_cc()
    {
        $id = $this->input->post('id', true);
        $data = [
            'tgl_kejadian' => $this->input->post('tgl_kejadian', true),
            'id_kejahatan' => $this->input->post('kejahatan', true),
            'id_kabupaten' => $this->input->post('kabupaten', true),
            'jumlah_cc' => $this->input->post('jumlah_cc', true),
            'id_polres' => $this->input->post('polres', true)
        ];
        $this->db->where('id_data_cc', $id);
        $this->db->update('tb_data_cc', $data);
    }

    public function delete_data_cc($id)
    {
        $this->db->where('id_data_cc', $id);
        $this->db->delete('tb_data_cc');
    }


    // =====================================
    function getUsers($postData = null)
    {
        $response = array();

        $draw = $postData['draw'];
        $start = isset($postData['start']) ? $postData['start'] : 0;
        $rowperpage = isset($postData['length']) ? $postData['length'] : 10;
        $columnIndex = isset($postData['order'][0]['column']) ? $postData['order'][0]['column'] : 0;
        $columnName = isset($postData['columns'][$columnIndex]['data']) ? $postData['columns'][$columnIndex]['data'] : "nomor";
        $columnSortOrder = isset($postData['order'][0]['dir']) ? $postData['order'][0]['dir'] : "asc";
        $searchValue = isset($postData['search']['value']) ? $postData['search']['value'] : '';


        $searchKejahatan = isset($postData['searchKejahatan']) ? $postData['searchKejahatan'] : '';
        $searchBulan = isset($postData['searchBulan']) ? $postData['searchBulan'] : '';
        $searchTahun = isset($postData['searchTahun']) ? $postData['searchTahun'] : '';
        $searchPolres = isset($postData['searchPolres']) ? $postData['searchPolres'] : '';
        $searchKabupaten = isset($postData['searchKabupaten']) ? $postData['searchKabupaten'] : '';
        $search_arr = array();
        $searchQuery = "";
        if ($searchValue != "") {
            $search_arr[] = "id_kejahatan like '%" . $searchValue . "%'  OR tb_data_cc.tgl_kejadian like '%" . $searchValue . "%' OR tb_data_cc.id_polres like '%" . $searchValue . "%'  OR tb_data_cc.id_kabupaten like '%" . $searchValue . "%' )";
        }
        if ($searchBulan != '') {
            $search_arr[] = "tb_data_cc.tgl_kejadian like '%" . $searchBulan . "%'";
        }
        if ($searchKejahatan != '') {
            $search_arr[] = "tb_data_cc.id_kejahatan like '%" . $searchKejahatan . "%'";
        }
        if ($searchPolres != '') {
            $search_arr[] = "tb_data_cc.id_polres like '%" . $searchPolres . "%'";
        }
        if ($searchKabupaten != '') {
            $search_arr[] = "tb_data_cc.id_kabupaten like '%" . $searchKabupaten . "%'";
        }
        if ($searchTahun != '') {
            $search_arr[] = "tb_data_cc.tgl_kejadian like '%" . $searchTahun . "%'";
        }
        if (count($search_arr) > 0) {
            $searchQuery = implode(" and ", $search_arr);
        }

        $this->db->select('*, count(*) as allcount, (ROW_NUMBER() OVER (Order by tb_data_cc.id_data_cc)) as nomor , tb_data_cc.id_data_cc as id');
        $this->db->from('tb_data_cc');
        $this->db->join('tb_kejahatan', 'tb_data_cc.id_kejahatan = tb_kejahatan.id_kejahatan', 'left');
        $this->db->join('tb_polres', 'tb_data_cc.id_polres = tb_polres.id_polres', 'left');
        $this->db->join('tb_kabupaten', 'tb_data_cc.id_kabupaten = tb_kabupaten.id_kabupaten', 'left');
        $records = $this->db->get()->result();

        $totalRecords = $records[0]->allcount;

        $this->db->select('*, count(*) as allcount');
        $this->db->from('tb_data_cc');
        $this->db->join('tb_kejahatan', 'tb_data_cc.id_kejahatan = tb_kejahatan.id_kejahatan', 'left');
        $this->db->join('tb_polres', 'tb_data_cc.id_polres = tb_polres.id_polres', 'left');
        $this->db->join('tb_kabupaten', 'tb_data_cc.id_kabupaten = tb_kabupaten.id_kabupaten', 'left');
        if ($searchQuery != '') $this->db->where($searchQuery);
        $record = $this->db->get()->result();
        $totalRecordwithFilter = $record[0]->allcount;

        $this->db->select('*, (ROW_NUMBER() OVER (Order by tb_data_cc.id_data_cc)) as nomor , tb_data_cc.id_data_cc as id');
        $this->db->from('tb_data_cc');
        $this->db->join('tb_kejahatan', 'tb_data_cc.id_kejahatan = tb_kejahatan.id_kejahatan', 'left');
        $this->db->join('tb_polres', 'tb_data_cc.id_polres = tb_polres.id_polres', 'left');
        $this->db->join('tb_kabupaten', 'tb_data_cc.id_kabupaten = tb_kabupaten.id_kabupaten', 'left');
        if ($searchQuery != '') $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();

        $data = array();

        foreach ($records as $record) {
            $data[] = array(
                "id" => $record->id,
                "nomor" => $record->nomor,
                "nama_polres" => $record->nama_polres,
                "tgl_kejadian" => $record->tgl_kejadian,
                "kejahatan" => $record->kejahatan,
                "id_kejahatan" => $record->id_kejahatan,
                "id_polres" => $record->id_polres,
                "id_kabupaten" => $record->id_kabupaten,
                "kabupaten" => $record->kabupaten,   
                "jumlah_cc" => $record->jumlah_cc,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecord" => $totalRecordwithFilter,
            "aaData" => $data
        );
        return $response;
    }


}

?>