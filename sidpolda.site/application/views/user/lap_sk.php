<style>
    h3 {
        font-family: times new roman;
    }

    small {
        font-size: 16px;
    }

    .rdu {
        font-size: 27px;
    }

    .daerah {
        font-size: 20px;
    }

    .jalan {
        font-size: 15px;
    }

    @media print {

        /* Hide Every other element */
        body,
        footer,
        header,
        content,
        nav {
            visibility: hidden;
        }

        title * {
            visibility: hidden;
        }

        .x_title {
            display: none;
            margin: 0px;
            padding: 0px;
        }

        #hide_div {
            display: none;
            margin: 0px;
            padding: 0px;
        }

        /*then displaying print x-content */
        .x_content,
        section * {
            visibility: visible;

        }

        .x_content {

            background-color: transparent !important:;
        }

        .x_panel,
            {
            background-color: transparent;
            margin: 2em;
            padding: 0px;
        }

        .clearfix {
            padding: 0px;
            margin: 0px;
        }

        @page {
            margin-top: 0px;
            margin-bottom: 0px;
        }
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 " id="hide_div">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Laporan Surat Keluar</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2><b>Filter Data</b></h2>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-4 col-sm-4">
                                <input type="hidden" id="s_mode">
                                <div class="input-group mb-3">
                                    <label class="col-sm-3 col-form-label label-align pl-0">Perihal</label>
                                    <div class="col-sm-9">
                                        <select class="custom-select" name="perihal" id="perihal">
                                            <option value="">-- Pilih Perihal --</option>
                                            <?php foreach ($perihal as $row) : ?>
                                                <option value="<?= $row['id_perihal'] ?>"><?= $row['perihal'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- <div class="input-group-append"> -->
                                        <!-- <button class="btn btn-primary" id="s_perihal"><i class="fa fa-search"></i></button> -->
                                        <!-- <label class="input-group-text" for="inputGroupSelect02"><i class="fa fa-search"></i></label> -->
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="col-sm-3 col-form-label label-align  pl-0">Bulan</label>
                                    <div class="col-sm-9">
                                        <input type="month" class="form-control" placeholder="Bulan" id="bulan" name="bulan">
                                        <!-- <div class="input-group-append"> -->
                                        <!-- <button class="btn btn-primary" id="s_bulan"><i class="fa fa-search"></i></button> -->
                                        <!-- <label class="input-group-text" for="inputGroupSelect02"><i class="fa fa-search"></i></label> -->
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group mb-3">
                                    <label class="col-sm-3 col-form-label label-align pl-0">Tahun</label>
                                    <div class="col-sm-9">


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
                                <table id="datatabel" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                        <div class="modal-body">
                            <div class="col-md-12 col-sm-12" id="div_sekretaris">
                                <div class="x_panel">
                                    <h2>Disposisi Sekretaris</h2>
                                    <div class="x_content">
                                        <table class="table table-striped">
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
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12" id="div_kepmar">
                                <div class="x_panel">
                                    <h2>Disposisi Kepala Markas</h2>
                                    <div class="x_content">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Kolom</th>
                                                    <th scope="col">Isi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">No Surat</th>
                                                    <td id="sl_no_surat"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Tanggal</th>
                                                    <td id="sl_tanggal"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Keterangan</th>
                                                    <td id="sl_keterangan"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 d-none" id="div_print">
            <div class="x_panel">
                <div class="x_title">
                    <h2 class="pr-3">Lembar Disposisi</h2>
                    <button class="btn btn-primary" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <img class="img-fluid" src="<?= base_url('assets/images/') ?>kopsleman.png" alt="" width="">
                    <div class="container pt-3 pb-5">
                        <h4 class="text-center"><u>LEMBAR DISPOSISI</u></h4>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2>Header</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <?php
                                    setlocale(LC_ALL, 'IND');
                                    $date = strftime("%d - %B - %Y", time());
                                    // echo "Saat ini: " . $date;
                                    ?>
                                    <tr>
                                        <th width="30%">
                                            <h6>No Agenda : <strong id="no_agenda"></strong>
                                            </h6>
                                        </th>
                                        <th width="30%">
                                            <h6>Tanggal Disposisi :
                                                <?= $date ?>
                                            </h6>
                                        </th>
                                        <th width="30%">
                                            <h6>Jenis Surat :
                                                Surat Keluar
                                            </h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <h6 class="pb-3">
                                                Asal Surat : <small id="asal_surat">-</small>
                                            </h6>
                                            <h6 class="pb-3">
                                                Isi Ringkasan : <small id="ringkasan">-</small>
                                            </h6>
                                            <h6 class="pb-3">
                                                Tanggal/No. Surat : <small id="surat">-</small>
                                            </h6>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <h6 class="pb-2">
                                            Isi Disposisi :
                                        </h6>
                                        <p><b>1. Disposisi Sekretaris</b></p>
                                        <p class="font-weight-bold" id="tgl_dis"></p>
                                        <p class="pb-3" id="isi_dis"></p>
                                        <p><b>2. Disposisi Kepala Markas</b></p>
                                        <p class="font-weight-bold" id="tgl_dl"></p>
                                        <p class="pb-3" id="isi_dl"></p>
                                    </td>
                                    <td>
                                        <h6 class="pb-2">
                                            Instruksi :
                                        </h6>
                                        <p class="pb-3" id="instruksi"></p>

                                    </td>
                                </tr>

                            </table>

                            <div>
                                <h6 class="text-right pb-5 mr-5">Mengetahui</h6>
                                <h6 class="text-right mt-5 mr-5 pr-2">Sekretaris</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>