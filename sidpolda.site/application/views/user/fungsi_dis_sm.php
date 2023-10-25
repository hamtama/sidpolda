<script text="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('Medium-modal'), {}),
        tabel = null;
    var lgModal = new bootstrap.Modal(document.getElementById('large-modal'), {}),
        tabel = null;

    $('.file-show').click(function() {
        var id = $(this).attr('id');
        var file = $(this).attr('data-text');
        if (file != "") {
            $("#tampil").removeClass('d-none');
            $("#show_img").addClass('d-none');
            $("#show_file").attr("src", "<?= base_url('assets/file_upload/surat_masuk/'); ?>" + file);
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

    $('.editBtn').click(function() {
        var id = $(this).attr('id');
        var url = "<?= base_url($menu['url'] . '/edit_select'); ?>";
        $('#mode').val("update");
        $('#id').val(id);
        $("#form_bobot").attr("action", "<?= base_url($menu['url'] . '/add_dis_sm'); ?>");
        $('#myLargeModalLabel').text('Disposisi Surat Masuk');
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
            }
        })
    });

    $('.tolak').click(function() {
        var id = $(this).attr('id');
        var url = "<?= base_url($menu['url'] . '/edit_select'); ?>";
        $('#mode').val("update");
        $('#id').val(id);
        $("#form_bobot").attr("action", "<?= base_url($menu['url'] . '/reject_dis_sm'); ?>");
        $('#myLargeModalLabel').text('Disposisi Surat Masuk');
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
            }
        })
    });
    $('.hapusbtn').click(function() {
        var id = $(this).attr('id');

        var a = "<?= base_url($menu['url'] . '/del_dis_sm/') ?>" + id;
        console.log(a);
        if (confirm("Yakin Ingin Menghapus Data Ini ? Menghapus Akan Mengembalikan Status Surat!")) {
            window.location.href = "<?= base_url($menu['url'] . '/del_dis_sm/'); ?>" + id;
        }
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
        var a = $('#nos').val();
        $('#no_surat,#keterangan').removeClass('is-valid');
        $('#no_surat,#keterangan').removeClass('is-invalid');
        $('#no_surat').val(a);
        $('#keterangan').text('');
    });
</script>