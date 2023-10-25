<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    <?php
    $kejahatan = "";
    $total = "";
    $total_cc = "";
    $warna = "";
    $warna_cc = "";
    $i = 1;
    $c = count($show_kejahatan);
    foreach ($show_kejahatan as $row) :
        if ($i < $c) {
            $kejahatan .= "'" . $row['kejahatan'] . "'" . ",";
            $warna .= "'" . $row['warna'] . "'" . ",";
            $total .= "'" . $row['total'] . "'" . ",";
            $warna_cc .= "'" . $row['warna_cc'] . "'" . ",";
            $total_cc .= "'" . $row['total_cc'] . "'" . ",";
        } else {
            $kejahatan .= "'" . $row['kejahatan'] . "'";
            $warna .= "'" . $row['warna'] . "'";
            $total .= "'" . $row['total'] . "'";
            $warna_cc .= "'" . $row['warna_cc'] . "'";
            $total_cc .= "'" . $row['total_cc'] . "'";
        }
        $i++;
    endforeach;


    $query = $this->db->select("MAX(jumlah_kejahatan) as total, sum(jumlah_kejahatan) as hasil")->from("tb_data_kejahatan")->get()->row_array();
    $max = $query['total'];
    $sum = $query['hasil'];
    $query_cc = $this->db->select("MAX(jumlah_cc) as total, sum(jumlah_cc) as hasil")->from("tb_data_cc")->get()->row_array();
    $max_cc = $query_cc['total'];
    $sum_cc = $query_cc['hasil'];
    ?>

    var kejahatan, total, total_cc, warna, warna_cc, hasil, myChart, tipe;

    kejahatan = [<?= $kejahatan ?>];
    total = [<?= $total ?>];
    total_cc = [<?= $total_cc ?>];
    warna = [<?= $warna ?>];
    warna_cc = [<?= $warna_cc ?>];
    hasil = <?= $sum ?>;
    hasil_cc = <?= $sum_cc ?>;
    tipe = 'bar';
    // console.log(kejahatan);

    $('#tahun, #bulan').change(function() {
        var select = $(this).attr('data-id');
        if (select == 'tahun') {
            $('#bulan').val('');
        } else if (select == 'bulan') {
            $('#tahun').val('');
        }
        var update = $('#' + select).val();
        console.log(update);
        kejahatan, total, warna, hasil, myChart, tipe = "";
        // console.log(bulan);
        $.ajax({
            url: "/admin/searchgraph",
            type: "POST",
            dataType: 'json',
            data: {
                update: update,
                select: select
            },
            success: function(data) {
                kejahatan = data.kejahatan.split(",");
                total = data.total.split(",");
                total_cc = data.total_cc.split(",");
                warna = data.warna.split(",");
                warna_cc = data.warna_cc.split(",");
                hasil = data.sum.nilai;
                hasil_cc = data.sum_cc.nilai;

                // console.log(warna_cc);
                tipe = $('#chartSelect').val();
                (tipe == "") ? tipe = 'bar': tipe = tipe;
                myChart.destroy();
                // variable();
                tampil();
            }
        });

    });

    Chart.register(ChartDataLabels);
    var ctx = document.getElementById('kejahatan').getContext('2d');

    function tampil() {
        // Chart.defaults.global.defaultFontFamily = "monospace";
        myData = {
            labels: kejahatan,
            datasets: [{
                label: 'Data Kejahatan',
                data: total,
                backgroundColor: warna,
            }, {

                label: 'Clear Crime',
                data: total_cc,
                backgroundColor: warna_cc,
            }]
        }
        myChart = new Chart(ctx, {
            type: tipe,
            data: myData,
            options: {
                responsive: true,
                aspectRatio: 3, //(width/height)
                // maintainAspectRatio: false,
                plugins: {
                    // Change options for ALL labels of THIS CHART
                    datalabels: {
                        color: '#fff',
                        formatter: (value, context, ctx) => {
                            let sum = hasil;
                            sum;
                            // context.dataIndex + ': ' + (value * 100 / sum).toFixed(2) + '%';
                            // let percentage = (value / sum * 100).toFixed(2) + '%';
                            // return percentage;
                        }
                    }
                }
            },
        });
    }
    tampil();

    $('#tahun, #bulan').change(function() {
        var update = $(this).attr('data-id');
        var filter = $('#' + update).val();

        kejahatan, total, warna, hasil, myChart, tipe = "";
        // console.log(bulan);
        $.ajax({
            url: "/admin/searchgraph",
            type: "POST",
            dataType: 'json',
            data: {
                filter: filter,

            },
            success: function(data) {
                kejahatan = [data.kejahatan];
                total = [data.total];
                warna = [data.warna];
                hasil = data.sum.nilai;
                tipe = $('#chartSelect').val();
                (tipe == "") ? tipe = 'bar': tipe = tipe;
                myChart.destroy();
                // variable();
                tampil();
            }
        });
    });


    $('#chartSelect').change(function() {
        myChart.destroy();
        tipe = $(this).val();
        (tipe == "") ? tipe = 'bar': tipe = tipe;
        // variable();
        tampil();
    });





    // =================== CHART BULANAN ============================
    var datagrafik, myChart_2, kab, thn, count;
    $('#tahun_2, #kabupaten_select').change(function() {
        datagrafik = "";
        thn = $('#tahun_2').val();
        kab = $('#kabupaten_select').val();


        $.ajax({
            url: '/admin/graphmonth',
            type: 'POST',
            dataType: 'json',
            data: {
                thn: thn,
                kab: kab
            },
            success: function(data) {
                count = Object.keys(data).length;
                // myChart_2.destroy();
                datagrafik += "{"
                datagrafik += '"labels": ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],';
                datagrafik += '"datasets"  : [';
                $.each(data, function(index, value) {

                    if (index < count) {
                        datagrafik += '{"data": [' + value.nilai + '],"label": "' + value.kejahatan + '","backgroundColor": "' + value.warna + '"},';
                    } else {
                        datagrafik += '{"data": [' + value.nilai + '],"label": "' + value.kejahatan + '","backgroundColor": "' + value.warna + '"}';
                    }
                });
                datagrafik += "]}";
                console.log(datagrafik);
                myChart_2.destroy();
                datagrafik = JSON.parse(datagrafik);
                tampil_2();
            }
        });
    });

    graphbulanan();

    function graphbulanan() {
        datagrafik = "";
        thn = "2022";
        kab = "";
        $.ajax({
            url: '/admin/graphmonth',
            type: 'POST',
            dataType: 'JSON',
            data: {
                thn: thn,
                kab: kab
            },
            success: function(data) {
                count = Object.keys(data).length;
                // myChart_2.destroy();
                datagrafik += "{"
                datagrafik += '"labels": ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],';
                datagrafik += '"datasets"  : [';
                $.each(data, function(index, value) {

                    if (index < count) {
                        datagrafik += '{"data": [' + value.nilai + '],"label": "' + value.kejahatan + '","backgroundColor": "' + value.warna + '"},';
                    } else {
                        datagrafik += '{"data": [' + value.nilai + '],"label": "' + value.kejahatan + '","backgroundColor": "' + value.warna + '"}';
                    }
                });
                datagrafik += "]}";
                console.log(datagrafik);
                datagrafik = JSON.parse(datagrafik);
                tampil_2();
            }
        });
    };



    // console.log(datagrafik);
    var btx = document.getElementById('bulanan').getContext('2d');
    // btx.height(500);

    function tampil_2() {
        datachart = datagrafik;
        myChart_2 = new Chart(btx, {
            type: 'bar',
            data: datachart,
            // maintainAspectRatio: false,
            options: {
                responsive: true,
                aspectRatio: 3,
                legend: {
                    position: "right",
                    align: "middle"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            //max: 100,
                            callback: function(value) {
                                return value + "%"
                            }
                        },
                        scaleLabel: {
                            display: true
                            //labelString: "Percentage"
                        }
                    }]
                }
            }
        });
    }
</script>