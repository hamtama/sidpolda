<script text="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('Medium-modal'), {}),
        tabel = null;

    $('.tambah').click(function() {
        $('#mode').val("create");
        $('#id').val("");
        $("#form_bobot").attr("action", "<?= base_url($menu['url'] . '/add'); ?>");
        $('#myLargeModalLabel').text('Tambah Data Sub Menu');
        myModal.toggle();
        $("#batal").on('click', function() {
            myModal.toggle();
        });
    });

    $('.editBtn').click(function() {
        var id = $(this).attr('id');
        var url = "<?= base_url($menu['url'] . '/edit_select'); ?>";
        $('#mode').val("update");
        $('#id').val(id);
        $("#form_bobot").attr("action", "<?= base_url($menu['url'] . '/update'); ?>");
        $('#myLargeModalLabel').text('Edit Submenu Data Menu');
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
                $('#menu').val(data.id_menu);
                $('#title').val(data.title);
                $('#url').val(data.url);
                $('#aktif').val(data.is_active);
                var a = $('#aktif').val();
                if (a === '1') {
                    $('#aktif').bootstrapToggle('on');
                } else {
                    $('#aktif').bootstrapToggle('off');
                }
            }
        })
    });

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
    $(document).ready(function() {
        $('.klik').change(function() {
            if ($(this).is(':checked')) {
                $('#aktif').val('1');
            }
            if (!$('.klik').is(':checked')) {
                $('#aktif').val('0');
            }
        });

    });

    $('#Medium-modal').on('hidden.bs.modal', function() {
        $('#menu,#title, #url').removeClass('is-valid');
        $('#menu,#title, #url').removeClass('is-invalid');
        $('#menu,#title, #url').val('');
        $('#aktif').removeAttr('checked');
    });

    $('.ubah').change(function() {
        var id_i = $(this).attr('id');
        var id = $(this).attr('data-id');
        var name = $(this).attr('name');
        if ($('#' + id_i).is(':checked')) {
            $('#' + id_i).val('1');
        }
        if (!$('#' + id_i).is(':checked')) {
            $('#' + id_i).val('0');
        }
        var isi = $('#' + id_i).val();
        var url = '<?= base_url($menu['url'] . '/aktifasi') ?>';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: {
                id: id,
                isi: isi
            },
            success: function(data) {}
        })
    });
</script>