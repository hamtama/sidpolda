<style>
    p {
        margin-bottom: 0px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Data Polres</h2>
                    <a href="polres" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="row">


                    <div class="col-md-6">
                        <div id="maps"></div>
                        <button onclick="fullScreenView()">View in full screen</button>
                        <div class="coordinate"></div>
                    </div>
                    <div class="col-md-6">

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="alert alert-info print-error-msg" style="display:none">
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label  pl-0">Nama Polres</label>
                                    <div class="col-sm-9 ">
                                        <input type="text" id="nama_polres" name="nama_polres" class="form-control" value="<?= $polres['nama_polres'] ?>" />
                                        <small class="text-danger"><?= form_error('nama_polres'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group row pr-2">
                                    <label class="col-sm-3 col-form-label  pl-0">File</label>
                                    <div class="custom-file col-sm-9 pb-5">
                                        <input type="file" class="custom-file-input" id="file_image" name="file_image" required>
                                        <label class="custom-file-label" id="image" for="file_image"><?= $polres['gambar'] ?></label>
                                        <small id="emailHelp" class="form-text text-muted">Format File: PNG, Jpeg | Size Max: 5Mb</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label  pl-0">Alamat</label>
                                    <div class="col-sm-9 ">
                                        <input type="text" id="alamat" name="alamat" class="form-control" value="<?= $polres['alamat']; ?>" />
                                        <small class="text-danger"><?= form_error('alamat'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label  pl-0">Kontak</label>
                                    <div class="col-md-9">
                                        <input type="number" id="kontak" name="kontak" class="form-control" value="<?= $polres['kontak']; ?>" maxlength="14" />
                                        <small class="text-danger"><?= form_error('kontak'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label pl-0">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" id="email" name="email" class="form-control" value="<?= $polres['email']; ?>" />
                                        <small class="text-danger"><?= form_error('email'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label  pl-0">Latitude</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="latitude" name="latitude" class="form-control" value="<?= $polres['latitude']; ?>" />
                                        <small class="text-danger"><?= form_error('latitude'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label  pl-0">Longitude</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="longitude" name="longitude" class="form-control" value="<?= $polres['longitude']; ?>" />
                                        <small class="text-danger"><?= form_error('longitude'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label  pl-0">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?= $polres['deskripsi']; ?>" />
                                        <small class="text-danger"><?= form_error('deskripsi'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <input type="hidden" id="mode" name="mode" value="" />
                                    <input type="hidden" id="id" name="id" value="<?= $polres['id_polres']; ?>" />
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="submit" id="simpan" class="btn btn-success"><i class="fa fa-send"></i>
                                    Simpan</button>
                                <button type="button" id="batal" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>