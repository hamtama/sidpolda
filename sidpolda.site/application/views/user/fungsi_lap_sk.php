<script text="text/javascript">
    // var myModal = new bootstrap.Modal(document.getElementById('Medium-modal'), {}),
    //     tabel = null;
    var lgModal = new bootstrap.Modal(document.getElementById('large-modal'), {}),
        tabel = null;
    var dismodal = new bootstrap.Modal(document.getElementById('dis-modal'), {}),
        tabel = null;


    $(document).ready(function() {

        tabel = $('#datatabel').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "responsive": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                "url": "<?= base_url($menu['url'] . '/userList'); ?>",
                "type": "POST",
                "data": function(data) {
                    data.searchTahun = $('#tahun').val();
                    data.searchBulan = $('#bulan').val();
                    data.searchPerihal = $('#perihal').val();

                }
            },
            "deferRender": true,
            "aLengthMenu": [
                [10, 25, 50],
                [10, 25, 50]
            ],
            "columnDefs": [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            "columns": [{
                    "render": function(data, type, row) {
                        if (row.id_status == '6' || row.id_status == '1') {
                            var html = '<button class="btn btn-xs btn-outline-info" disabled id="' + row.id_surat_keluar + '"><i class=" fa fa-eye-slash"></i></button>';
                        } else if (row.id_status == '3') {
                            var html = '<button class="btn btn-xs btn-outline-info show_dis1" id="' + row.id_surat_keluar + '"><i class=" fa fa-eye"></i></button>';
                        } else if (row.id_status == '4') {
                            var html = '<button class="btn btn-xs btn-outline-info show_dis2" id="' + row.id_surat_keluar + '"><i class=" fa fa-eye"></i></button>';
                            html += '<button class="btn btn-xs btn-outline-info cetak" id="' + row.id_surat_keluar + '"><i class=" fa fa-print"></i></button>';
                        }

                        return html;
                    },
                    "className": "text-center"
                },
                {
                    "data": "nomor",
                    "className": "text-start"
                },
                {
                    "data": "no_surat_keluar",
                    "className": "text-center"
                },
                {
                    "data": "tgl_surat",
                    "className": "text-center"
                },
                {
                    "data": "tujuan",
                    "className": "text-center"
                },
                {
                    data: "file_sk",
                    "render": function(data, type, row) {
                        return '<button type="button" class="btn btn-outline-primary file-show" id="' + row.nomor + '" data-text="' + row.file_sk + '">Lihat File</button>'
                    },
                    "className": "text-center"
                },
                {
                    "data": "perihal",
                    "className": "text-center"
                },
                {
                    data: "status",
                    "render": function(data, type, row) {
                        return '<b class="rounded p-2 mb-2 ' + row.warna + ' text-white">' + row.status + '</b>'
                    },
                    "className": "text-center"
                },
            ],
        });
        $('#perihal,#bulan,#tahun').change(function() {
            tabel.draw();
        });


        $('#datatabel tbody').on('click', '.file-show', function() {
            var id = $(this).attr('id');
            var file = $(this).attr('data-text');
            console.log(file);
            if (file != "") {
                $("#tampil").removeClass('d-none');
                $("#show_img").addClass('d-none');
                $("#show_file").attr("src", "<?= base_url('assets/file_upload/surat_keluar/'); ?>" + file);
            } else {
                $("#show_img").removeClass('d-none');
                $("#tampil").addClass('d-none');
                $("#show_img").attr("src", "<?= base_url('assets/file_upload/default.jpg'); ?>");
            }
            // console.log(file);
            $('#myModalLabel').text('File Surat Masuk');
            lgModal.toggle();
            $("#close").on('click', function() {
                lgModal.toggle();
            });
        });


        $('#datatabel tbody').on('click', '.show_dis1', function() {
            var id = $(this).attr('id');
            console.log(id);
            var url = "<?= base_url($menu['url'] . '/select_dis'); ?>";
            $('#div_kepmar').hide();
            $('#myModaldis').text('Disposisi Surat Keluar');
            dismodal.toggle();
            $("#batal").on('click', function() {
                dismodal.toggle();
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#s_no_surat').text(data.no_surat_keluar);
                    $('#s_tanggal').text(data.tanggal);
                    $('#s_keterangan').text(data.keterangan);
                    console.log(data.no_surat_keluar);
                }

            })
        });

        $('#datatabel tbody').on('click', '.show_dis2', function() {
            var id = $(this).attr('id');
            var url = "<?= base_url($menu['url'] . '/select_dis2'); ?>";
            $('#id').val(id);

            $('#div_kepmar').show();
            $('#myModaldis').text('Disposisi Surat Keluar');
            dismodal.toggle();
            $("#batal").on('click', function() {
                dismodal.toggle();
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data2) {
                    $('#s_no_surat').text(data2.no_surat_keluar);
                    $('#s_tanggal').text(data2.tgl);
                    $('#s_keterangan').text(data2.ket);
                    $('#sl_no_surat').text(data2.no_surat_keluar);
                    $('#sl_tanggal').text(data2.tanggal);
                    $('#sl_keterangan').text(data2.keterangan);
                }
            })
        });

        $('#datatabel tbody').on('click', '.cetak', function() {
            var id = $(this).attr('id');
            var url = "<?= base_url($menu['url'] . '/cetak'); ?>";
            $('#div_print').removeClass('d-none', true);
            console.log(id);
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#no_agenda').text(data.id_surat);
                    $('#asal_surat').text(data.tujuan);
                    $('#ringkasan').text(data.keterangan);
                    var tgl_no = data.tgl_surat + '/' + data.no_surat_keluar;
                    $('#surat').text(tgl_no);
                    $('#tgl_dis').text(data.tgl_dis);
                    $('#tgl_dl').text(data.tgl_dl);
                    $('#isi_dis').text(data.ket_dis);
                    $('#isi_dl').text(data.ket_dl);
                    $('#instruksi').text(data.instruksi);
                    console.log(tgl_no);
                    window.print();
                    $('#div_print').addClass('d-none', true);
                }
            });
        });

        $('#Medium-modal').on('hidden.bs.modal', function() {
            var a = $('#nos').val();
            $('#no_surat,#keterangan').removeClass('is-valid');
            $('#no_surat,#keterangan').removeClass('is-invalid');
            $('#no_surat').val(a);
            $('#keterangan').text('');
        });
    });
</script>