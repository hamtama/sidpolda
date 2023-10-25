<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data Surat Keluar</h2>
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
                                        $queryData = "SELECT *, (ROW_NUMBER() OVER (Order by id_surat_keluar)) as nomor FROM tb_surat_keluar a INNER JOIN tb_perihal b ON a.perihal = b.id_perihal
                                        INNER JOIN tb_status c ON a.status = c.id_status WHERE a.status=1";
                                        $data = $this->db->query($queryData)->result_array();
                                        foreach ($data as $row) :
                                            $i = $row['id_surat_keluar'];
                                        ?>
                                            <tr>
                                                <td width="10%">
                                                    <button class="btn btn-xs btn-outline-info editBtn" id="<?= $row['id_surat_keluar'] ?>"><i class=" fa fa-pencil-square"></i></button>
                                                    <a href="<?= base_url($menu['url'] . '/delete/' . $row['id_surat_keluar']) ?>" onclick="return confirm('Yakin Ingin Mengapus Data');" class="btn btn-xs btn-outline-info deleteBtn" id="<?= $row['id_surat_keluar'] ?>"><i class="fa fa-trash"></i></a>
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
                                <?php
                                $m = date('m');
                                $y = date('Y');
                                $query = "SELECT * FROM tb_surat_keluar order by id_surat_keluar DESC limit 1";
                                $s = $this->db->query($query);
                                $data2 = $this->db->query($query)->result_array();
                                if ($s->num_rows() < 1) {
                                    $no = "SK000";
                                    $no = preg_replace("/[^0-9.]/", "", $no);
                                    $no = $no + 1;
                                    $no = "SK00" . $no . "/" . $m . "/" . $y;
                                } else {
                                    foreach ($data2 as $row2) :
                                        $nosurat = $row2['no_surat_keluar'];


                                        $no = $nosurat;
                                        $no = explode("/", $no, 3);
                                        $no = preg_replace("/[^0-9.]/", "", $no[0]);
                                        $no = $no + 1;
                                        if ($no < 10) {
                                            $no = "00" . $no;
                                            // print_r($no);
                                        } elseif ($no >= 10 && $no <= 99) {
                                            $no = "0" . $no;
                                            ($no);
                                        } elseif ($no >= 100) {
                                            ($no = $no);
                                        }
                                        $no = "SK" . $no . "/" . $m . "/" . $y;

                                    endforeach;
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">No Surat</label>
                                    <input type="text" id="no_surat" readonly name="no_surat" value="<?= $no ?>" class="form-control" />
                                    <div class="invalid-feedback errorno_surat_keluar"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Tanggal Surat</label>
                                    <input type="date" id="tgl_surat" value="<?= date('Y-m-d') ?>" name="tgl_surat" class="form-control" />
                                    <div class="invalid-feedback errortgl_surat"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Tujuan</label>
                                    <input type="text" id="tujuan" name="tujuan" class="form-control" />
                                    <div class="invalid-feedback errortujuan"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">File Surat Keluar</label>
                                    <div class="custom-file">
                                        <input type="file" id="file_sk" name="file_sk" class="custom-file-input" required>
                                        <label class="custom-file-label" for="file_sk" id="l_file_sk">Choose file...</label>
                                        <small id="emailHelp" class="form-text text-muted">Format File: pdf | Size Max: 5Mb</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Perihal</label>
                                    <select name="perihal" id="perihal" class="form-control">
                                        <option value="">-- Pilih Perihal --</option>
                                        <?php foreach ($perihal as $row) : ?>
                                            <option value="<?= $row['id_perihal'] ?>"><?= $row['perihal'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback errorperihal"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Isi Ringkasan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" cols="30" rows="5"></textarea>
                                    <div class="invalid-feedback errorketeragan"></div>
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
    </div>
</div>