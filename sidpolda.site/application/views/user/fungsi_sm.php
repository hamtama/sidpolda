<script text="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('Medium-modal'), {}),
        tabel = null;
    var lgModal = new bootstrap.Modal(document.getElementById('large-modal'), {}),
        tabel = null;

    $('.custom-file-input').on('change', function() {
        let filename = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(filename);
    });

    $('.tambah').click(function() {
        $('#mode').val("create");
        $('#id').val("");
        $('#file_sm').attr('required', true);
        $("#form_bobot").attr("action", "<?= base_url($menu['url'] . '/add'); ?>");
        $('#myLargeModalLabel').text('Tambah Data Surat Masuk');
        myModal.toggle();
        $("#batal").on('click', function() {
            myModal.toggle();
        });
    });
    $('.file-show').click(function() {
        var id = $(this).attr('id');
        var file = $('#' + id).attr('data');
        if (file != "") {
            $("#tampil").removeClass('d-none');
            $("#show_img").addClass('d-none');
            $("#show_file").attr("src", "<?= base_url('assets/file_upload/surat_masuk/'); ?>" + file);
        } else {
            $("#show_img").removeClass('d-none');
            $("#tampil").addClass('d-none');
            $("#show_img").attr("src", "<?= base_url('assets/file_upload/default.jpg'); ?>");
        }
        // console.log(id);

        $('#myModalLabel').text('File Surat Masuk');
        lgModal.toggle();

        $("#close").on('click', function() {
            lgModal.toggle();
            $('#show').attr('data', "");
        });
    });

    $('.editBtn').click(function() {
        var id = $(this).attr('id');
        var url = "<?= base_url($menu['url'] . '/edit_select'); ?>";
        $('#mode').val("update");
        $('#id').val(id);
        $('#file_sm').attr('required', false);
        $("#form_bobot").attr("action", "<?= base_url($menu['url'] . '/update'); ?>");
        $('#myLargeModalLabel').text('Edit Data Surat Masuk');
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
                $('#no_surat').val(data.no_surat_masuk);
                $('#tgl_surat').val(data.tgl_surat);
                $('#asal_surat').val(data.asal_surat);
                $('#l_file_sm').text(data.file_sm);
                $('#perihal').val(data.perihal);
                $('#keterangan').html(data.keterangan);
            }
        })
    });

    $('#form_bobot').on('submit', function(e) {
        $('#simpan').text('Mohon Tunggu'); //change button text
        $('#simpan').attr('disabled', true); //set button enable
        var opt = ($('#mode').val() === "create") ? "Tambah" : "Update";
        var url = $("#form_bobot").attr('action');
        console.log(url);
        e.preventDefault();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
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
        var a = $('#nos').val();
        $('#no_surat,#tgl_surat, #asal_surat,#file_sm,#perihal').removeClass('is-valid');
        $('#no_surat,#tgl_surat, #asal_surat,#file_sm,#perihal').removeClass('is-invalid');
        $('#tgl_surat,#asal_surat,#perihal').val("");

        $('#no_surat').val(a);
        $('#keterangan').text('');
        $('#l_file_sm').text('Choose file...');
    });
</script>