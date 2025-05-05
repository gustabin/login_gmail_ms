const params = new URLSearchParams(window.location.search);
const token = params.get('token');
if (!token) {
    Swal.fire('Error', 'Invalid token', 'error');
}
$('#token').val(token);

$('#resetForm').on('submit', function (e) {
    e.preventDefault();

    if ($('#password').val() !== $('#confirm').val()) {
        Swal.fire('Error', 'Passwords do not match', 'error');
        return;
    }

    $("#barra").show();
    $.ajax({
        url: '../actions/reset_password.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            $("#barra").hide();
            let res = JSON.parse(response);
            if (res.success) {
                Swal.fire('¡Password updated!', res.message, 'success').then(() => {
                    window.location = 'index.html';
                });
            } else {
                Swal.fire('Error', res.error, 'error');
            }
        }
    });
});