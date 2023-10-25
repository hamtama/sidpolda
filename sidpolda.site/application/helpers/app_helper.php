<?php
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    } else {
        $id_role = $ci->session->userdata('id_role');
        $menu = $ci->uri->segment(1);
        $queryMenu = $ci->db->get_where('user_sub_menu', ['url' => $menu])->row_array();
        $menu_id = $queryMenu['id_menu'];
        $userAccess = $ci->db->get_where('user_access_menu', [
            'id_role' => $id_role,
            'id_menu' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function check_access($id_role, $id_menu)
{
    $ci = get_instance();

    $ci->db->where('id_role', $id_role);
    $ci->db->where('id_menu', $id_menu);

    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_dis($id, $surat)
{
    if ($surat == 'sm') {
        $id_surat = 'id_surat_masuk';
        $tb_dis = 'tb_dis_sm';
    } elseif ($surat == 'sk') {
        $id_surat = 'id_surat_keluar';
        $tb_dis = 'tb_dis_sk';
    }
    $ci = get_instance();
    $ci->db->where($id_surat, $id);
    $result = $ci->db->get($tb_dis);
    // $querydis = $ci->db->get_where($tb_dis, [$id_surat => $id])->row_array();
    // $id_dis = $querydis['id_dis_sm'];
    if ($result->num_rows() > 0) {
        return '<button class="btn btn-xs btn-outline-info hapusbtn" id="' . $id . '"><i class=" fa fa-trash"></i></button>';
    } else {
        return '<button class="btn btn-xs btn-outline-info editBtn" id="' . $id . '"><i class=" fa fa-check-square-o"></i></button> <button class="btn btn-xs btn-outline-info tolak" id="' . $id . '"><i class=" fa fa-close"></i></button>';
    }
}



function check_dl($id, $surat)
{
    if ($surat == 'sm') {
        $id_surat = 'id_surat_masuk';
        $tb_dis = 'tb_dl_sm';
    } elseif ($surat == 'sk') {
        $id_surat = 'id_surat_keluar';
        $tb_dis = 'tb_dl_sk';
    }
    $ci = get_instance();
    $ci->db->where($id_surat, $id);
    $result = $ci->db->get($tb_dis);
    // $querydis = $ci->db->get_where('tb_dl_sm', ['id_surat_masuk' => $id])->row_array();
    // $id_dis = $querydis['id_dl_sm'];
    if ($result->num_rows() > 0) {
        return '<button class="btn btn-xs btn-outline-info hapusbtn" id="' . $id . '"><i class=" fa fa-trash"></i></button>';
    } else {
        return '<button class="btn btn-xs btn-outline-info editBtn" id="' . $id . '"><i class=" fa fa-check-square-o"></i></button> <button class="btn btn-xs btn-outline-info tolak" id="' . $id . '"><i class=" fa fa-close"></i></button>';
    }
}


function check_lap($id, $surat)
{
    if ($surat == 'sm') {
        $id_surat = 'id_surat_masuk';
        $tb_dis = 'tb_dis_sm';
        $tb_dl = 'tb_dl_sm';
    } elseif ($surat == 'sk') {
        $id_surat = 'id_surat_keluar';
        $tb_dis = 'tb_dis_sk';
        $tb_dl = 'tb_dl_sk';
    }
    $ci = get_instance();
    $ci->db->where($id_surat, $id);
    $result = $ci->db->get($tb_dis);
    $ci->db->where($id_surat, $id);
    $result2 = $ci->db->get($tb_dl);
    if ($result->num_rows() > 0 && $result2->num_rows() > 0) {
        return '<button class="btn btn-xs btn-outline-info show_dis2" id="' . $id . '"><i class=" fa fa-eye"></i></button>';
    } elseif ($result->num_rows() > 0 && $result2->num_rows() == 0) {
        return '<button class="btn btn-xs btn-outline-info show_dis1" id="' . $id . '"><i class=" fa fa-eye"></i></button>';
    } elseif ($result->num_rows() == 0 && $result2->num_rows() == 0) {
        return '<button class="btn btn-xs btn-outline-info" disabled id="' . $id . '"><i class=" fa fa-eye"></i></button>';
    }
}
