<style>
    h3 {
        font-family: times new roman;
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
<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
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
                    <img class="img-fluid" src="<?= base_url('assets/images/') ?>kopsuratpmi.png" alt="" width="">
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
                                            <h6>No Agenda : 1
                                            </h6>
                                        </th>
                                        <th width="30%">
                                            <h6>Tanggal Diterima :
                                                <?= $date ?>
                                            </h6>
                                        </th>
                                        <th width="30%">
                                            <h6>Jenis Surat :
                                                Surat Masuk
                                            </h6>
                                        </th>
                                    </tr>


                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <h6 class="pb-3">
                                                Asal Surat : <small>Tentang singkat</small>
                                            </h6>
                                            <h6 class="pb-3">
                                                Isi Ringkasan : <small>Tentang singkat</small>
                                            </h6>
                                            <h6 class="pb-3">
                                                Tanggal/No. Surat : <small>Tentang singkat</small>
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
                                        <p class="pb-3" id="isi_dis1"></p>
                                        <p><b>2. Disposisi Kepala Markas</b></p>
                                        <p lass="pb-3" id="isi_dis2"></p>
                                    </td>
                                    <td>
                                        <h6 class="pb-2">
                                            Instruksi :
                                        </h6>
                                        <p><b>1. Disposisi Sekretaris</b></p>
                                        <p class="pb-3" id="isi_dis1"></p>
                                        <p><b>2. Disposisi Kepala Markas</b></p>
                                        <p lass="pb-3" id="isi_dis2"></p>
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