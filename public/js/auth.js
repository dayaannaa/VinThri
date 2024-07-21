$(document).ready(function() {
    $('#login-form').on('submit', function(event) {
        event.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            url: 'api/login',
            type: 'POST',
            dataType: 'json',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                alert('Login successful!');

                localStorage.setItem('token', response.token);
                localStorage.setItem('customer_id', response.customer_id);
                localStorage.setItem('admin_id', response.admin_id); // Store admin_id in localStorage

                $('#customer-id').text(response.customer_id);
                $('#customer-info').show();

                $('#admin-id').text(response.admin_id);
                $('#admin-info').show();

                alert('Logged in account user ID: ' + response.user_id);
                alert('Customer ID: ' + response.customer_id);
                alert('Admin ID: ' + response.admin_id);

                window.location.href = '/products/display';
            },
            error: function(response) {
                alert('Login failed: ' + response.responseJSON.error);
            }
        });
    });

    // AJAX request to get user info (optional)
    $.ajax({
        url: 'api/user',
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        success: function(response) {
            console.log('User Info:', response);
        },
        error: function(response) {
            console.log('Error: ' + response.responseJSON.error);
        }
    });

    $('#signup-form').on('submit', function(event) {
        event.preventDefault();

        var first_name = $('#signup-first_name').val();
        var last_name = $('#signup-last_name').val();
        var address = $('#signup-address').val();
        var email = $('#signup-email').val();
        var password = $('#signup-password').val();

        $.ajax({
            url: 'api/register',
            type: 'POST',
            dataType: 'json',
            data: {
                first_name: first_name,
                last_name: last_name,
                address: address,
                email: email,
                password: password
            },
            success: function(response) {
                alert('Registration successful!');
                $('#signup-modal').addClass('hidden');
            },
            error: function(response) {
                alert('Registration failed: ' + response.responseJSON.error);
            }
        });
    });

    $('#open-signup-modal').on('click', function(event) {
        event.preventDefault();
        $('#signup-modal').removeClass('hidden');
    });

    $('#close-signup-modal').on('click', function(event) {
        event.preventDefault();
        $('#signup-modal').addClass('hidden');
    });
});