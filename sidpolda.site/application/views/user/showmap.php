<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="card mb-3">
                    <div class="card-header">
                        <h2><b>Filter Data</b></h2>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="col-form-label label-align  pl-0">Bulan</label>
                                    <div class="col-sm-12 p-0">
                                        <input type="month" class="form-control" placeholder="Bulan" id="bulan" name="bulan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button onclick="fullScreenView()">View in full screen</button>
                <div class="coordinate"></div>

                <div id="maps"></div>
                <div id="info-container">
                    <div class="card" style="width: 18rem;">
                        <button type="button" class="close position-absolute p-1" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <img id="img_show" class="card-img-top" src="" alt="Card image cap">
                        <div class="card-body">
                            <h5 id="location-name" class="card-title">Card title</h5>
                            <p id="address" class="card-text"></p>
                            <p id="additional-info" class="card-text"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>