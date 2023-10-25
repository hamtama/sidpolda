<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Disposisi Surat Keluar</h2>
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

                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>No.</th>
                                            <th>No Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>Tujuan</th>
                                            <th>File</th>
                                            <th>Perihal</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $queryData = "SELECT *, (ROW_NUMBER() OVER (Order by id_surat_keluar)) as nomor FROM tb_surat_keluar a 
                                        INNER JOIN tb_perihal b ON a.perihal = b.id_perihal
                                        INNER JOIN tb_status c ON a.status = c.id_status WHERE a.status=1 ";
                                        $data = $this->db->query($queryData)->result_array();
                                        foreach ($data as $row) :
                                            $i = $row['id_surat_keluar'];
                                        ?>
                                            <tr>
                                                <td width="10%">
                                                    <?= check_dl($row['id_surat_keluar'], 'sk')  ?>
                                                    <button class="btn btn-xs btn-outline-info show_dis" id="<?= $row['id_surat_keluar'] ?>"><i class=" fa fa-eye"></i></button>
                                                </td>
                                                <td><?= $row['nomor'] ?></td>
                                                <td><?= $row['no_surat_keluar'] ?></td>
                                                <td><?= $row['tgl_surat'] ?></td>
                                                <td><?= $row['tujuan'] ?></td>
                                                <td><button type="button" class="btn btn-outline-primary file-show" id="<?= $row['nomor'] ?>" data-text="<?= $row['file_sk']; ?>">Lihat File</button></td>
                                                <td><?= $row['perihal'] ?></td>
                                                <td class="text-center"> <b class="rounded p-2 mb-2 <?= $row['warna'] ?> text-white"><?= $row['status'] ?></b></td>
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
                                    <label class="col-sm-12 col-form-label  pl-0">No Surat</label>
                                    <!-- <input type="hidden" id="nos" value=""> -->
                                    <input type="text" id="no_surat" readonly name="no_surat" class="form-control" />
                                    <div class="invalid-feedback errorno_surat_masuk"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Instruksi</label>
                                    <!-- <input type="hidden" id="nos" value=""> -->
                                    <input type="text" id="instruksi" name="instruksi" class="form-control" />
                                    <div class="invalid-feedback errorinstruksi"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" cols="30" rows="5"></textarea>
                                    <div class="invalid-feedback errorketerangan"></div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="mode" name="mode" value="" />
                                    <input type="hidden" id="id" name="id" value="" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" class="btn btn-success"><i class="fa fa-check-square-o"></i></button>
                                <button type="button" id="batal" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-example-modal-lg " id="large-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="show_img" src="" class="rounded img-thumbnail" alt="...">
                        <div class="embed-responsive embed-responsive-4by3" id="tampil">
                            <!-- <object id="show" width="100%" height="800px" class="embed-responsive-item" data=""></object> -->
                            <iframe id="show_file" src="" width="100%" class="embed-responsive-item" height="800px" frameborder="0"></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bs-example-modal-lg " id="dis-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModaldis">Modal title</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Kolom</th>
                                    <th scope="col">Isi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">No Surat</th>
                                    <td id="s_no_surat"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal</th>
                                    <td id="s_tanggal"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Keterangan</th>
                                    <td id="s_keterangan"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>