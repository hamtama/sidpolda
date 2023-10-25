<script text="text/javascript">
    $('.ubah').change(function() {
        var id_menu = $(this).attr('id');
        var id_role = <?= $akses['id_role']; ?>;
        if ($('#' + id_menu).is(':checked')) {
            $('#' + id_menu).val('1');
            var url = '<?= base_url($menu['url'] . '/aktifasi') ?>';
        }
        if (!$('#' + id_menu).is(':checked')) {
            $('#' + id_menu).val('0');
            var url = '<?= base_url($menu['url'] . '/deaktifasi') ?>';
        }
        console.log(url);
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: {

                id_menu: id_menu,
                id_role: id_role
            },
            success: function(data) {}
        })
    });
</script>