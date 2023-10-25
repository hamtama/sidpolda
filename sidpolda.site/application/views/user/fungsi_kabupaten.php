<script text="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('Medium-modal'), {}),
    tabel = null;

$('.tambah').click(function() {
    $('#mode').val("create");
    $('#id').val("");
    $("#form_bobot").attr("action", "<?= base_url($menu['url'] . '/add'); ?>");
    $('#myLargeModalLabel').text('Tambah Data Kabupaten');
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
    $('#myLargeModalLabel').text('Edit Kabupaten Data');
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
            $('#kabupaten').val(data.kabupaten);
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

$('#Medium-modal').on('hidden.bs.modal', function() {
    $('#kabupaten').removeClass('is-valid');
    $('#kabupaten').removeClass('is-invalid');
    $('#kabupaten').val('');
});
</script>