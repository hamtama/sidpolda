<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <!-- <h3>Multilevel Menu <small> Page to demonstrate multilevel menu</small></h3> -->

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="">
                    <div class="x_content">

                        <div class="col-md-12 col-sm-12 p-0">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Dashboar Data Berdasarkan Kejahatan Konvensional</h2>
                                    <ul class="nav nav-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h2><b>Filter Data</b></h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <div class="col-md-4 col-sm-3">
                                                    <div class="form-group mb-3">
                                                        <label class="col-form-label label-align  pl-0">Bulan</label>
                                                        <div class="col-sm-12 p-0">
                                                            <input type="month" class="form-control" placeholder="Bulan" id="bulan" data-id="bulan" name="bulan">
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
                                                            print '<select class="form-control" id="tahun" data-id="tahun" name="tahun_cetak">';
                                                            print '<option value ="">-- Pilih Tahun --</option>';
                                                            foreach (range($hinggal_tanggal, $mulai_tanggal) as $cetak_tahun) {
                                                                print '<option value="' . $cetak_tahun . '"' . ($cetak_tahun === $tanggal ? ' selected="selected"' : '') . '>' . $cetak_tahun . '</option>';
                                                            }
                                                            print '</select>';
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-3">
                                                        <label class="col-form-label label-align  pl-0">Chart</label>
                                                        <div class="col-sm-12 p-0">
                                                            <select name="chart" id="chartSelect" class="form-control select">
                                                                <option value="">-- Pilih Chart --</option>
                                                                <option value="pie">Pie</option>
                                                                <option value="bar">Bar</option>
                                                                <option value="radar">Radar</option>
                                                                <option value="polarArea">Polar Area</option>
                                                                <option value="doughnut">Doughnut</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <canvas id="kejahatan" style="position: relative; height:80vh; width:80vw"></canvas>
                                    <div id="js-legend" style="display: inline-block;width: 12px; height: 12px; margin-right: 5px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 p-0">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Dashboar Data Bulanan Kejahatan Konvensional</h2>
                                    <ul class="nav nav-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h2><b>Filter Data</b></h2>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class=" col-form-label label-align pl-0">Tahun</label>
                                                        <div class="col-sm-12 p-0">
                                                            <?php
                                                            $tanggal = date('Y');
                                                            $mulai_tanggal = 2000;
                                                            $hinggal_tanggal = date('Y');
                                                            print '<select class="form-control" id="tahun_2" name="tahun_cetak">';
                                                            print '<option value ="">-- Pilih Tahun --</option>';
                                                            foreach (range($hinggal_tanggal, $mulai_tanggal) as $cetak_tahun) {
                                                                print '<option value="' . $cetak_tahun . '"' . ($cetak_tahun === $tanggal ? ' selected="selected"' : '') . '>' . $cetak_tahun . '</option>';
                                                            }
                                                            print '</select>';
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="col-form-label" for="kabupaten">Kabupaten</label>
                                                        <div class="col-sm-12 p-0">
                                                            <select class="form-control select" name="pilih_kabupaten" id="kabupaten_select">
                                                                <option value="">-- Pilih Kabupaten --</option>

                                                                <?php foreach ($kabupaten as $s) : ?>
                                                                    <option value="<?= $s['id_kabupaten'] ?>"><?= $s['kabupaten'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <canvas id="bulanan" style="position: relative; height:80vh; width:80vw"></canvas>
                                    <div id="js-legend_bulan" style="display: inline-block;width: 12px; height: 12px; margin-right: 5px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->