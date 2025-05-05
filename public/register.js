$('#registerForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: '../actions/register.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            let res = JSON.parse(response);
            if (res.success) {
                Swal.fire('¡Registration successful!', '', 'success').then(() => {
                    window.location = 'index.html';
                });
            } else {
                Swal.fire('Error', res.error, 'error');
            }
        }
    });
});
