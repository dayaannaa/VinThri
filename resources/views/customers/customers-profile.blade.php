<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>
    @include('layouts.header')
    <h2 style="text-align: left; margin-left: 60px; margin-top: 30px; margin-bottom: 10px; font-family: Alfa Slab One, serif; color: #5F6F52; font-size: 30px;">Customer Profile</h2>
    <style>
   .image-container {
        position: relative;
        width: 250px; /* Adjust size as needed */
        height: 250px; /* Adjust size as needed */
        margin: 0 auto; /* Centers the image container within the card */
        overflow: hidden;
        border-radius: 50%;
    }

    .customer-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        position: absolute;
        top: 0;
        left: 0;
        display: none; /* Initially hide all images */
    }
    </style>

    <div id="customersContainer" class="card-container mb-3">
        <!-- Customer cards will be injected here -->
    </div>

    <!-- Modal for Edit Customer -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="customerForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                        </div>
                        <input type="hidden" id="customerId">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        // Fetch the customer_id from localStorage
        var customerId = localStorage.getItem('customer_id');

        if (customerId) {
            $.ajax({
                url: `/api/customers?customer_id=${customerId}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        var customer = response[0];
                        $('#first_name').val(customer.first_name);
                        $('#last_name').val(customer.last_name);
                        $('#address').val(customer.address);
                        $('#email').val(customer.email);

                        if (customer.image) {
                            var images = customer.image.split(',');
                            var imageHtml = images.map(function(img) {
                                return `<img src="/imgs/${img}" class="img-thumbnail" style="max-width: 100px; max-height: 100px; margin-right: 10px;">`;
                            }).join(' ');
                            $('#images').html(imageHtml);
                        }
                    } else {
                        $('#customersContainer').html('<p>No customer data available.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#customersContainer').html('<p>Error fetching customer data.</p>');
                }
            });
        } else {
            $('#customersContainer').html('<p>No customer ID found.</p>');
        }

        $('#customerForm').on('submit', function(event) {
            event.preventDefault();
            var id = $('#customerId').val();
            var url = `/api/customers/${id}`;
            var formData = new FormData(this);
            formData.append('_method', 'PUT'); // Use PUT for update

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#customerModal').modal('hide');
                    alert('Profile updated successfully.');
                    window.location.reload(); // Refresh the page
                },
                error: function(xhr, status, error) {
                    var errorMessage = 'Error: Failed to process the request.';
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = Object.values(errors).flat();
                        errorMessage += '\nValidation Errors:\n' + errorMessages.join('\n');
                    } else if (xhr.status === 500) {
                        errorMessage += '\nServer Error: ' + xhr.responseText;
                    } else {
                        errorMessage += '\nHTTP Status: ' + xhr.status + ' ' + xhr.statusText;
                    }
                    alert(errorMessage);
                }
            });
        });


        $(document).ready(function() {
    function loadCustomers() {
        $.ajax({
            url: '/api/customers',
            data: { customer_id: customerId },
            dataType: 'json',
            success: function(customers) {
                $('#customersContainer').empty();
                customers.forEach(function(customer) {
                    var images = customer.image ? customer.image.split(',') : [];
                    if (images.length > 0) {
                        var imageHtml = images.map(function(img) {
                            return `<img src="/imgs/${img}" class="customer-image" alt="Customer Image">`;
                        }).join(' ');

                        var cardHtml = `
    <div class="card">
        <div class="card-body">
            <div class="image-container">
                ${imageHtml}
            </div>
            <div class="mb-3">
                <label for="first_name_${customer.customer_id}" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name_${customer.customer_id}" value="${customer.first_name}" readonly>
            </div>
            <div class="mb-3">
                <label for="last_name_${customer.customer_id}" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name_${customer.customer_id}" value="${customer.last_name}" readonly>
            </div>
            <div class="mb-3">
                <label for="address_${customer.customer_id}" class="form-label">Address</label>
                <input type="text" class="form-control" id="address_${customer.customer_id}" value="${customer.address}" readonly>
            </div>
            <div class="mb-3">
                <label for="email_${customer.customer_id}" class="form-label">Email</label>
                <input type="email" class="form-control" id="email_${customer.customer_id}" value="${customer.email}" readonly>
            </div>
            <button class="btn btn-sm btn-primary editCustomer" data-id="${customer.customer_id}">Edit</button>
        </div>
    </div>
`;

                        $('#customersContainer').append(cardHtml);

                        // Start image cycling
                        startImageCycling(`#customersContainer .card:last-child .customer-image`);
                    }
                });
            }
        });
    }

    function startImageCycling(imageSelector) {
        var $images = $(imageSelector);
        var currentIndex = 0;
        $images.eq(currentIndex).show();

        setInterval(function() {
            $images.eq(currentIndex).fadeOut(1000, function() {
                currentIndex = (currentIndex + 1) % $images.length;
                $images.eq(currentIndex).fadeIn(1000);
            });
        }, 3000);
    }

        $('#customersContainer').on('click', '.editCustomer', function() {
            var customerId = $(this).data('id');
            $.get(`/api/customers/${customerId}`, function(customer) {
                $('#customerModalLabel').text('Edit Customer');
                $('#first_name').val(customer.first_name);
                $('#last_name').val(customer.last_name);
                $('#address').val(customer.address);
                $('#email').val(customer.email);
                $('#customerId').val(customer.customer_id);
                $('#password').val(customer.password); // Clear password for editing

                $('#customerModal').modal('show');
            });
        });

        loadCustomers();
    });

});
</script>
</body>
</html>