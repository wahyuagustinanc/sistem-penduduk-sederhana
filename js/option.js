$(document).ready(function() {
    $('#id_provinsi').change(function() {
        var provinsi_id = $(this).val();

        $.ajax({
            type: 'POST', //method
            url: 'kabupaten.php', //action
            data: 'id_prov=' + provinsi_id, //$_POST('id_prov')
            success: function(response) {
                $('#id_kabupaten').html(response);
            }
        });
    })
});