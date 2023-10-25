<script text="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('Medium-modal'), {}),
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
            "url": "kejahatan/list",
            "type": "POST",
            "data": function(data) {
                data.searchTahun = $('#tahun').val();
                data.searchBulan = $('#bulan').val();
                data.searchPolres = $('#j_polres').val();
                data.searchKejahatan = $('#j_kejahatan').val();
                data.searchKabupaten = $('#j_kabupaten').val();
                console.log(data.searchKabupaten);
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
                    var html = '<button class="btn btn-xs btn-outline-info editBtn" id="' + row
                        .id + '"><i class=" fa fa-pencil-square"></i></button>';
                    html += '<a href="/delete_data_kejahatan/' + row.id +
                        '" onclick="return confirm("Yakin Ingin Mengapus Data");" class="btn btn-xs btn-outline-info deleteBtn" id="' +
                        row.id + '"><i class="fa fa-trash"></i></a>';
                    return html;
                },
                "className": "text-center"
            },
            {
                "data": "nomor",
                "className": "text-start"
            },
            {
                "data": "tgl_kejadian",
                "className": "text-center"
            },
            {
                "data": "nama_polres",
                "className": "text-center"
            },
            {
                "data": "kabupaten",
                "className": "text-center"
            },
            {
                "data": "kejahatan",
                "className": "text-center"
            },
            {
                "data": "jumlah_kejahatan",
                "className": "text-center"
            },
        ],
    });
    $('#j_kejahatan, #bulan, #tahun, #j_polres, #j_kabupaten').change(function() {
        tabel.draw();
    });

    $('.tambah').on('click', function() {
        $('#mode').val("create");
        $('#id').val("");
        $("#form_bobot").attr("action", "<?= $menu['url'] . '/add_ikejahatan' ?>");
        $('#myLargeModalLabel').text('Tambah Input Data Kejahatan');
        myModal.toggle();
        $("#batal").on('click', function() {
            myModal.toggle();
        });
    })

    $('#datatabel tbody').on('click', '.editBtn', function() {
        var id = $(this).attr('id');
        var url = "<?= $menu['url'] . '/edit_select_ikejahatan' ?>";
        $('#mode').val("update");
        $('#id').val(id);
        $("#form_bobot").attr("action", "<?= $menu['url'] . '/update_ikejahatan' ?>");
        $('#myLargeModalLabel').text('Edit Input Data Kejahatan');

        myModal.toggle();

        $("#batal").on('click', function() {
            myModal.toggle();
        });
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: {
                id: id
            },
            success: function(data) {
                $('#kejahatan').val(data.id_kej);
                $('#tgl_kejadian').val(data.tgl_kejadian);
                $('#jumlah_kejahatan').val(data.jumlah_kejahatan);
                $('#polres').val(data.id_polres);
                $('#kabupaten').val(data.id_kab);
            }
        })
    })



    $('#form_bobot').on('submit', function(e) {
        $('#simpan').text('Mohon Tunggu'); //change button text
        $('#simpan').attr('disabled', true); //set button enable
        // var str = $(this).serialize();
        var opt = ($('#mode').val() === "create") ? "Tambah" : "Update";
        var url = $("#form_bobot").attr('action');
        console.log(url);
        e.preventDefault();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: $(this).serialize(),
            success: function(data) {
                for (let i = 0; i < data.input.length; i++) {
                    if (data.error[data.input[i]]) {
                        $('#' + data.input[i]).addClass('is-invalid');
                        $('.error' + data.input[i]).html(data.error[data.input[i]]);
                    } else {
                        $('#' + data.input[i]).removeClass('is-invalid');
                        $('#' + data.input[i]).addClass('is-valid');
                    }
                    $('#simpan').text('Simpan'); //change button text
                    $('#simpan').attr('disabled', false); //set button enable 
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(opt + ' Data Berhasil');
                $('#Medium-modal').hide();
                location.reload();
            }
        });
    });

    $('#Medium-modal').on('hidden.bs.modal', function() {
        $('#kejahatan, #kabupaten, #polres, #tgl_kejadian, #jumlah_kejahatan').removeClass('is-valid');
        $('#kejahatan, #kabupaten, #polres, #tgl_kejadian, #jumlah_kejahatan ').removeClass(
            'is-invalid');
        $('#kejahatan, #kabupaten, #polres, #tgl_kejadian, #jumlah_kejahatan').val('');
    });
});
</script>