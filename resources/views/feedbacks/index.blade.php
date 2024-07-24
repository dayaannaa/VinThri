<!DOCTYPE html>
<html>
<head>
    <title>Feedbacks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <style>
        .feedback-container {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 40px;
            display: flex;
            align-items: flex-start;
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }
        .feedback-image {
            max-width: 150px;
            max-height: 150px;
            margin-right: 15px;
        }
        .feedback-details {
            flex: 1;
            margin-right: 160px;
        }
        .feedback-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            flex-direction: column;
        }
        .feedback-actions button {
            margin-bottom: 5px;
        }
        .view-image-btn {
            background-color: #007bff;
            color: #fff;
        }
        .view-image-btn:hover {
            background-color: #0056b3;
        }
        .modal-body img {
            max-width: 100%;
            max-height: 80vh;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Feedbacks</h2>
    <div id="feedbackContainer"></div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Submit Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="feedbackForm">
                        <input type="hidden" id="feedbackId">
                        <input type="hidden" id="feedbackOrderItemId">
                        <input type="hidden" id="feedbackCustomerId">
                        <div class="form-group">
                            <label for="feedbackText">Feedback</label>
                            <textarea class="form-control" id="feedbackText" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="feedbackImages">Upload Images</label>
                            <input type="file" class="form-control-file" id="feedbackImages" name="images[]" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Image View Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">View Feedback Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="imageContainer">
                        <button id="prevImage" class="btn btn-secondary"><</button>
                        <img id="modalImage" src="" class="img-fluid">
                        <button id="nextImage" class="btn btn-secondary">></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    var customerId = localStorage.getItem('customer_id');
    var currentImageIndex = 0;
    var images = [];

    function renderFeedbacks(data) {
        var container = $('#feedbackContainer');
        container.empty();

        data.forEach(function(feedback) {
            var productImage = feedback.order_item.product.images ? feedback.order_item.product.images.split(',')[0] : '';

            container.append(`
                <div class="feedback-container">
                    ${productImage ? `<img src="/imgs/${productImage}" class="feedback-image">` : ''}
                    <div class="feedback-details">
                        <h5>${feedback.order_item.product.name}</h5>
                        <p><strong>Price:</strong> $${feedback.order_item.product.price}</p>
                        <p><strong>Date:</strong> ${feedback.date}</p>
                        <p><strong>Feedback:</strong> ${feedback.description}</p>
                    </div>
                    <div class="feedback-actions">
                        <button class="btn btn-secondary feedback-btn" data-order-item-id="${feedback.order_item_id}">Give Feedback</button>
                        <button class="btn btn-primary edit-feedback-btn" data-feedback-id="${feedback.feedback_id}">Edit</button>
                        <button class="btn btn-danger delete-feedback-btn" data-feedback-id="${feedback.feedback_id}">Delete</button>
                        ${feedback.images ? `<button class="btn btn-info view-image-btn" data-images="${feedback.images}">View Images</button>` : ''}
                    </div>
                </div>
            `);
        });
    }

    $.ajax({
        url: '/api/feedbacks',
        data: { customer_id: customerId },
        dataType: 'json',
        success: function(response) {
            renderFeedbacks(response);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching feedbacks:', error);
            alert('An error occurred. Please try again.');
        }
    });


    $(document).on('click', '.feedback-btn', function() {
        var orderItemId = $(this).data('order-item-id');
        $('#feedbackOrderItemId').val(orderItemId);
        $('#feedbackCustomerId').val(customerId);
        $('#feedbackModal').modal('show');
    });


    $(document).on('click', '.edit-feedback-btn', function() {
        var feedbackId = $(this).data('feedback-id');
        $.ajax({
            url: `/api/feedbacks/${feedbackId}`,
            type: 'GET',
            success: function(response) {
                $('#feedbackId').val(response.feedback_id);
                $('#feedbackText').val(response.description);
                $('#feedbackOrderItemId').val(response.order_item_id);
                $('#feedbackCustomerId').val(response.customer_id);
                $('#feedbackModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching feedback:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });


    $(document).on('click', '.delete-feedback-btn', function() {
        if (confirm('Are you sure you want to delete this feedback?')) {
            var feedbackId = $(this).data('feedback-id');
            $.ajax({
                url: `/api/feedbacks/${feedbackId}`,
                type: 'DELETE',
                success: function(response) {
                    alert('Feedback deleted successfully!');
                    $.ajax({
                        url: '/api/feedbacks',
                        data: { customer_id: customerId },
                        dataType: 'json',
                        success: function(response) {
                            renderFeedbacks(response);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting feedback:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });

    $('#feedbackForm').submit(function(e) {
        e.preventDefault();

        const feedbackText = $('#feedbackText').val();
        const orderItemId = $('#feedbackOrderItemId').val();
        const customerId = localStorage.getItem('customer_id');
        const feedbackId = $('#feedbackId').val();

        // Create FormData object
        const formData = new FormData();
        formData.append('order_item_id', orderItemId);
        formData.append('customer_id', customerId);
        formData.append('description', feedbackText);

        // Append images
        const files = $('#feedbackImages')[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        // Determine URL and HTTP method based on feedbackId
        let url = '/api/feedbacks';
        let method = 'POST'; // Default to POST for creating feedback

        if (feedbackId) {
            url = `/api/feedbacks/${feedbackId}`;
            formData.append('_method', 'PUT'); // Add _method to handle PUT request
        }

        $.ajax({
            url: url,
            method: method,
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#feedbackModal').modal('hide');
                window.location.reload();
                alert(feedbackId ? 'Feedback updated successfully!' : 'Feedback submitted successfully!');
            },
            error: function(xhr, status, error) {
                console.error('Error submitting feedback:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });

    $(document).on('click', '.view-image-btn', function() {
        var imageList = $(this).data('images').split(',');
        images = imageList;
        currentImageIndex = 0;
        $('#imageModal').modal('show');
        $('#modalImage').attr('src', '/imgs/' + images[currentImageIndex]);
    });

    $('#prevImage').click(function() {
        if (images.length > 0) {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            $('#modalImage').attr('src', '/imgs/' + images[currentImageIndex]);
        }
    });

    $('#nextImage').click(function() {
        if (images.length > 0) {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            $('#modalImage').attr('src', '/imgs/' + images[currentImageIndex]);
        }
    });
});
</script>
</body>
</html>
