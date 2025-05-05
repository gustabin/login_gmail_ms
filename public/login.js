$('#loginForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: '../actions/login.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            let res = JSON.parse(response);
            if (res.success) {
                Swal.fire('¡Login successful!', '', 'success').then(() => {
                    window.location = 'dashboard.html';
                });
            } else {
                Swal.fire('Error', res.error, 'error');
            }
        }
    });
});
