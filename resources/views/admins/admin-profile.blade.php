@extends('layouts.master')

@section('title', 'Customer Management')

@section('content')
    <h2>Admin Profile</h2>
    <style>
        .image-container {
            position: relative;
            width: 250px; /* Adjust size as needed */
            height: 250px; /* Adjust size as needed */
            margin: 0 auto; /* Centers the image container within the card */
            overflow: hidden;
            border-radius: 50%;
        }

        .admin-image {
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

    <div id="adminsContainer" class="card-container mb-3">
        <!-- Admin cards will be injected here -->
    </div>

    <!-- Modal for Edit Admin -->
    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminModalLabel">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adminForm" enctype="multipart/form-data">
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
                        <input type="hidden" id="adminId">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Fetch the admin_id from localStorage
        var adminId = localStorage.getItem('admin_id');

        if (adminId) {
            $.ajax({
                url: `/api/admins?admin_id=${adminId}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        var admin = response[0];
                        $('#first_name').val(admin.first_name);
                        $('#last_name').val(admin.last_name);
                        $('#address').val(admin.address);
                        $('#email').val(admin.email);

                        if (admin.image) {
                            var images = admin.image.split(',');
                            var imageHtml = images.map(function(img) {
                                return `<img src="/imgs/${img}" class="img-thumbnail" style="max-width: 100px; max-height: 100px; margin-right: 10px;">`;
                            }).join(' ');
                            $('#images').html(imageHtml);
                        }
                    } else {
                        $('#adminsContainer').html('<p>No admin data available.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#adminsContainer').html('<p>Error fetching admin data.</p>');
                }
            });
        } else {
            $('#adminsContainer').html('<p>No admin ID found.</p>');
        }

        $('#adminForm').on('submit', function(event) {
            event.preventDefault();
            var id = $('#adminId').val();
            var url = `/api/admins/${id}`;
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
                    $('#adminModal').modal('hide');
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

        function loadAdmins() {
            $.ajax({
                url: '/api/admins',
                data: { admin_id: adminId },
                dataType: 'json',
                success: function(admins) {
                    $('#adminsContainer').empty();
                    admins.forEach(function(admin) {
                        var images = admin.image ? admin.image.split(',') : [];
                        if (images.length > 0) {
                            var imageHtml = images.map(function(img) {
                                return `<img src="/imgs/${img}" class="admin-image" alt="Admin Image">`;
                            }).join(' ');

                            var cardHtml = `
                                <div class="card">
                                    <div class="card-body">
                                        <div class="image-container">
                                            ${imageHtml}
                                        </div>
                                        <div class="mb-3">
                                            <label for="first_name_${admin.admin_id}" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name_${admin.admin_id}" value="${admin.first_name}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name_${admin.admin_id}" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name_${admin.admin_id}" value="${admin.last_name}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address_${admin.admin_id}" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address_${admin.admin_id}" value="${admin.address}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email_${admin.admin_id}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email_${admin.admin_id}" value="${admin.email}" readonly>
                                        </div>
                                        <button class="btn btn-sm btn-primary editAdmin" data-id="${admin.admin_id}">Edit</button>
                                    </div>
                                </div>
                            `;

                            $('#adminsContainer').append(cardHtml);

                            // Start image cycling
                            startImageCycling(`#adminsContainer .card:last-child .admin-image`);
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

        $('#adminsContainer').on('click', '.editAdmin', function() {
            var adminId = $(this).data('id');
            $.get(`/api/admins/${adminId}`, function(admin) {
                $('#adminModalLabel').text('Edit Admin');
                $('#first_name').val(admin.first_name);
                $('#last_name').val(admin.last_name);
                $('#address').val(admin.address);
                $('#email').val(admin.email);
                $('#adminId').val(admin.admin_id);
                $('#password').val(admin.password); // Clear password for editing

                $('#adminModal').modal('show');
            });
        });

        loadAdmins();
    });
</script>
@endsection
