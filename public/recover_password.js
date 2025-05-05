$('#recoverForm').on('submit', function (e) {
    e.preventDefault();
    $("#barra").show();
    $.ajax({
        url: '../actions/send_reset_email.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            $("#barra").hide();
            let res = JSON.parse(response);
            if (res.success) {
                Swal.fire('¡Link sent!', res.message, 'success');
            } else {
                Swal.fire('Error', res.error, 'error');
            }
        }
    });
});