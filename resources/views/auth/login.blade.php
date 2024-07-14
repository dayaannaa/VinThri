<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="login-form">
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <div id="customer-info" style="display: none;">
        <p>Customer ID: <span id="customer-id"></span></p>
    </div>

    <div id="admin-info" style="display: none;">
        <p>Admin ID: <span id="admin-id"></span></p>
    </div>
</body>
</html>

<script>
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
});
</script>
