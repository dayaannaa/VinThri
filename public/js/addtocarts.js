$(document).ready(function() {
    // Extract product_id from URL or another source (assuming passed from display.js)
    var path = window.location.pathname;
    var productId = path.split('/').pop(); // Get the last segment of the URL path

    // AJAX request to fetch product details based on productId
    $.ajax({
        url: '/api/products/' + productId, // Adjust endpoint based on your Laravel route
        method: 'GET',
        dataType: 'json',
        success: function(product) {
            var images = product.images.split(','); // Split the images string into an array
            var imagesHtml = '';
            var radioButtonsHtml = '';

            // Build HTML for images and radio buttons
            images.forEach(function(image, index) {
                var isChecked = index === 0 ? 'checked' : ''; // Mark the first image as checked by default

                imagesHtml += `
                    <div class="product-image" id="image-${productId}-${index}" style="display: ${index === 0 ? 'block' : 'none'};">
                        <img src="/imgs/${image.trim()}" class="card-img-top" alt="${product.name}">
                    </div>
                `;
                radioButtonsHtml += `
                    <input type="radio" name="image-${productId}" value="${index}" ${isChecked} onclick="showImage(${productId}, ${index})">
                `;
            });

            var productHtml = `
                <div class="product-details">
                    <h2>${product.name}</h2>
                    <div class="image-selection">
                        ${imagesHtml}
                    </div>
                    <div class="radio-buttons">
                        ${radioButtonsHtml}
                    </div>
                    <p><strong>Price:</strong> ${product.price}</p>
                    <p>${product.description}</p>
                </div>
            `;
            $('#product-details-container').html(productHtml); // Display product details in this container
        },
        error: function(error) {
            console.log('Error fetching product details:', error);
        }
    });

    // Click event handler for Add to Cart button
    $('#addToCartBtn').click(function() {
        // Retrieve the customer_id from local storage
        var customerId = localStorage.getItem('customer_id');

        if (customerId) {
            // Display the customer_id in the HTML
            $('#customer-id').text(customerId);
        } else {
            alert('No customer ID found. Please log in again.');
            window.location.href = '/login';
            return;
        }

        // Extract quantity from the DOM or another source (assuming available in the DOM)
        var quantity = $('#quantity').val(); // Assuming quantity is retrieved from an input field

        // Alert all values for debugging
        alert('Product ID: ' + productId + ', Customer ID: ' + customerId + ', Quantity: ' + quantity);

        // Make an AJAX request to add product to cart
        $.ajax({
            url: '/api/addtocart/' + productId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                product_id: productId, // Include product_id in the data
                customer_id: customerId,
                quantity: quantity
            },
            success: function(response) {
                alert('Product added to cart successfully!');
                // Optionally, you can redirect or update the UI here
            },
            error: function(xhr) {
                alert('Failed to add product: ' + xhr.responseText);
            }
        });
    });
});
