<!-- page content -->

<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Input Data Kejahatan</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h2><b>Filter Data</b></h2>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-4 col-sm-4">
                                <input type="hidden" id="s_mode">
                                <div class="input-group mb-3">
                                    <label class="col-form-label label-align pl-0">Jenis Kejahatan</label>
                                    <div class="col-sm-12 p-0   ">
                                        <select name="j_kejahatan" id="j_kejahatan" class="custom-select">
                                            <option value="">-- Pilih Jenis Kejahatan --</option>
                                            <?php foreach ($cb_kejahatan as $row) : ?>
                                            <option value="<?= $row['id_kejahatan'] ?>"><?= $row['kejahatan'] ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <input type="hidden" id="s_mode">
                                <div class="input-group mb-3">
                                    <label class="col-form-label label-align pl-0">Polres</label>
                                    <div class="col-sm-12 p-0">
                                        <select name="j_polres" id="j_polres" class="custom-select">
                                            <option value="">-- Pilih Polres --</option>
                                            <?php foreach ($polres as $s) : ?>
                                            <option value="<?= $s['id_polres'] ?>"><?= $s['nama_polres'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <input type="hidden" id="s_mode">
                                <div class="input-group mb-3">
                                    <label class="col-form-label label-align pl-0">Kabupaten</label>
                                    <div class="col-sm-12 p-0">
                                        <select name="j_kabupaten" id="j_kabupaten" class="custom-select">
                                            <option value="">-- Pilih Kabupaten --</option>
                                            <?php foreach ($kabupaten as $s) : ?>
                                            <option value="<?= $s['id_kabupaten'] ?>"><?= $s['kabupaten'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="col-form-label label-align  pl-0">Bulan</label>
                                    <div class="col-sm-12 p-0">
                                        <input type="month" class="form-control" placeholder="Bulan" id="bulan"
                                            name="bulan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group mb-3">
                                    <label class=" col-form-label label-align pl-0">Tahun</label>
                                    <div class="col-sm-12 p-0">


                                        <?php
                                        $tanggal = date('Y');
                                        $mulai_tanggal = 2000;
                                        $hinggal_tanggal = date('Y');

                                        print '<select class="form-control" id="tahun" name="tahun_cetak">';
                                        print '<option value ="">-- Pilih Tahun --</option>';
                                        foreach (range($hinggal_tanggal, $mulai_tanggal) as $cetak_tahun) {
                                            print '<option value="' . $cetak_tahun . '"' . ($cetak_tahun === $tanggal ? ' selected="selected"' : '') . '>' . $cetak_tahun . '</option>';
                                        }
                                        print '</select>';
                                        ?>
                                        <!-- <div class="input-group-append"> -->
                                        <!-- <button class="btn btn-primary" id="s_tahun"><i class="fa fa-search"></i></button> -->
                                        <!-- <label class="input-group-text" for="inputGroupSelect02"><i class="fa fa-search"></i></label> -->
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                $tgl = date("Y-m-d");
                if ($this->session->flashdata('message')) : ?>
                <div class="alert alert-danger alert-dismissible " role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                    <strong><?= $this->session->flashdata('message'); ?>.</strong>
                </div>
                <?php
                endif;
                ?>
                <div class="col-md-12 col-sm-12 text-left">
                    <button type="button" class="btn btn-success tambah"><i class="icon-copy dw dw-add"></i>
                        Tambah</button>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatabel" class="table table-striped table-bordered dt-responsive nowrap"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>No.</th>
                                            <th>Tanggal Kejadian</th>
                                            <th>Polres</th>
                                            <th>Kabupaten</th>
                                            <th>Kejahatan</th>
                                            <th>Jumlah Kejahatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 mb-30">
            <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                aria-hidden="true">
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

                                    <label class="col-sm-12 col-form-label pl-0" for="tgl_kejadian">Tanggal
                                        Kejadian</label>

                                    <input type="date" name="tgl_kejadian" max="<?= $tgl ?>" id="tgl_kejadian"
                                        class="form-control">
                                    <div class="invalid-feedback errortgl_kejadian"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Polres</label>
                                    <select name="polres" id="polres" class="form-control">
                                        <option value="">-- Pilih Polres --</option>
                                        <?php foreach ($polres as $s) : ?>
                                        <option value="<?= $s['id_polres'] ?>"><?= $s['nama_polres'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback errorpolres"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Kabupaten</label>
                                    <select name="kabupaten" id="kabupaten" class="form-control">
                                        <option value="">-- Pilih Kabupaten --</option>
                                        <?php foreach ($kabupaten as $s) : ?>
                                        <option value="<?= $s['id_kabupaten'] ?>"><?= $s['kabupaten'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback errorkabupaten"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-form-label  pl-0">Kejahatan</label>
                                    <select name="kejahatan" id="kejahatan" class="form-control">
                                        <option value="">-- Pilih Kejahatan --</option>
                                        <?php foreach ($cb_kejahatan as $row) : ?>
                                        <option value="<?= $row['id_kejahatan'] ?>"><?= $row['kejahatan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback errorkejahatan"></div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_kejahatan">Jumlah Kejahatan</label>
                                    <input type="number" class="form-control" name="jumlah_kejahatan"
                                        id="jumlah_kejahatan">
                                    <div class="invalid-feedback errorjumlah_kejahatan"></div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="mode" name="mode" value="" />
                                    <input type="hidden" id="id" name="id" value="" />
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" class="btn btn-success"><i class="fa fa-send"></i>
                                    Simpan</button>
                                <button type="button" id="batal" class="btn btn-secondary"
                                    data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>