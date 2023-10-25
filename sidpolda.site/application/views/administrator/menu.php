<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data Menu</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <?php
                if ($this->session->flashdata('message')) : ?>
                    <div class="alert alert-danger alert-dismissible " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong><?= $this->session->flashdata('message'); ?>.</strong>
                    </div>
                <?php
                endif;
                ?>
                <div class="col-md-12 col-sm-12 text-left">
                    <button type="button" class="btn btn-success tambah"><i class="icon-copy dw dw-add"></i> Tambah</button>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>No.</th>
                                            <th>Menu</th>
                                            <th>Ikon</th>
                                            <th>Urutan</th>
                                            <th class="text-center">Is Active</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $queryData = "SELECT *, (ROW_NUMBER() OVER (Order by id_menu)) as nomor FROM user_menu";
                                        $data = $this->db->query($queryData)->result_array();
                                        foreach ($data as $row) :
                                            $i = $row['id_menu'];
                                        ?>
                                            <tr>
                                                <td width="10%">
                                                    <button class="btn btn-xs btn-outline-info editBtn" id="<?= $row['id_menu'] ?>"><i class=" fa fa-pencil-square"></i></button>
                                                    <a href="<?= base_url($menu['url'] . '/delete/' . $row['id_menu']) ?>" onclick="return confirm('Yakin Ingin Mengapus Data');" class="btn btn-xs btn-outline-info deleteBtn" id="<?= $row['id_menu'] ?>"><i class="fa fa-trash"></i></a>
                                                </td>
                                                <td><?= $row['nomor'] ?></td>
                                                <td><?= $row['menu'] ?></td>
                                                <td><?= $row['icon'] ?></td>
                                                <td><?= $row['urutan'] ?></td>
                                                <td class="d-flex justify-content-center">
                                                    <?php ($row['is_active'] == 1) ? $a = 'checked="checked"' : $a = ""; ?>
                                                    <input type="checkbox" data-id="<?= $row['id_menu'] ?>" <?= $a ?> class="text-center ubah" name="aktifasi<?= $i ?>" id="aktifasi<?= $i ?>" data-width="75" data-toggle="toggle" data-on="Active" data-off="Deactive" data-size="sm" data-onstyle="success" value="<?= $row['is_active'] ?>" />
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 mb-30">
            <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="form_bobot" method="post">
                            <div class="modal-body">
                                <div class="alert alert-info print-error-msg" style="display:none">
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Menu</label>
                                    <input type="text" id="menu" name="menu" class="form-control" />
                                    <div class="invalid-feedback errormenu"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Ikon</label>
                                    <input type="text" id="ikon" name="ikon" class="form-control" />
                                    <div class="invalid-feedback errorikon"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Urutan</label>
                                    <input type="number" id="urutan" name="urutan" class="form-control" min="1" max="20" onKeyPress="if(this.value.length==2) return false;" />
                                    <div class="invalid-feedback errorurutan"></div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="mode" name="mode" value="" />
                                    <input type="hidden" id="id" name="id" value="" />
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" class="btn btn-success"><i class="fa fa-send"></i> Simpan</button>
                                <button type="button" id="batal" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>