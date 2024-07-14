// var daisyUICDN = document.createElement('link');
// daisyUICDN.rel = 'stylesheet';
// daisyUICDN.href = 'https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css';
// document.head.appendChild(daisyUICDN);

$(document).ready(function () {
    var path = window.location.pathname;
    var productId = path.split('/').pop();

    $.ajax({
        url: '/api/products/' + productId,
        method: 'GET',
        dataType: 'json',
        success: function (product) {
            var images = product.images.split(',');
            var imagesHtml = '';
            var radioButtonsHtml = '';

            images.forEach(function (image, index) {
                var isChecked = index === 0 ? 'checked' : '';

                imagesHtml += `
                    <div class="product-image" id="image-${productId}-${index}" style="display: ${index === 0 ? 'block' : 'none'}; width: 350px; margin-left: 200px; border-radius: 15px;">
                        <img src="/imgs/${image.trim()}" class="card-img-top" alt="${product.name}">
                    </div>
                `;
                radioButtonsHtml += `
                    <input type="radio" name="image-${productId}" value="${index}" ${isChecked} onclick="showImage(${productId}, ${index})">
                `;
            });
            {/* <div class="card lg:card-side bg-base-100 shadow-xl" style="width: 600px; margin-left: 70px; margin-top: 50px;">
                        <h2 class="card-title">${product.name}</h2>
                            <div class="row justify-content-center mb-3">
                            <div class="col-md-12 col-xl-10">
                                <div class="radio-buttons"> ${radioButtonsHtml} </div>
                                <p><strong>Price:</strong> ${product.price}</p>
                                <p>${product.description}</p>
                                <label for="quantity">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" style="width: 100px; margin-bottom: 10px;">
                                <div class="card-actions justify-end">
                                    <button id="addToCartBtn" class="btn btn-primary">Add to Cart</button>
                                </div>
                            </div>
                            </div>
                            </div>*/}
            var productHtml = `
                <div class="container" style="padding-right: 50px; margin-top: 20px;">
                    <div class="row">
                        <div class="col" style="margin-top: 30px;">
                            ${imagesHtml}
                        <div style="margin-left: 200px;"> ${radioButtonsHtml} </div>
                        </div>
                        <div class="col" style="margin-top: 30px; margin-left: 50px;">
                            <h2 style="font-family: Alfa Slab One, serif; color: #B99470; font-size: 35px;">${product.name}</h2>
                            <p style="font-family: Poppins, sans-serif; font-weight: 600; color: #A9B388; font-size: 30px;"><strong>&#8369; </strong>${product.price}</p>
                            <p style="width: 500px;">${product.description}</p>
                        <div class="row" style="align-items: center; margin-top: 150px;">
                            <div class="col-auto">
                                <label for="quantity" style="font-family: Poppins, sans-serif; color: #5F6F52; font-size: 14px;">Quantity:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" style="margin-bottom: 10px; font-family: Poppins, sans-serif; color: #5F6F52;
                                background-color: rgba(169, 179, 136, 0.3); border-radius: 30px; height: 25px; width: 100px; margin-left: 320px;">
                            </div>
                            <div style="width: 510px; height: 1px; background-color: rgba(185, 148, 112, 0.3); margin-left: 15px; margin-top: 10px;"> </div>
                        </div>
                            <div style="margin-top: 20px;">
                                <button id="addToCartBtn" class="btn btn-primary" style="width: 510px; border-radius: 25px; background-color: #5F6F52; border-color: transparent; font-size: 12px;
                                font-family: Poppins, sans-serif; height: 40px; color: #FEFAE0;">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#product-details-container').html(productHtml);
        },
        error: function (error) {
            console.log('Error fetching product details:', error);
        }
    });

    $(document).on('click', '#addToCartBtn', function () {
        var customerId = localStorage.getItem('customer_id');
        if (customerId) {
            $('#customer-id').text(customerId);
        } else {
            alert('No customer ID found. Please log in again.');
            window.location.href = '/login';
            return;
        }

        var quantity = $('#quantity').val();

        $.ajax({
            url: '/api/addtocart/' + productId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                product_id: productId,
                customer_id: customerId,
                quantity: quantity
            },
            success: function (response) {
                alert('Product added to cart successfully!');
            },
            error: function (xhr) {
                alert('Failed to add product: ' + xhr.responseText);
            }
        });
    });
});

function showImage(productId, index) {
    $(`.product-image[id^='image-${productId}-']`).hide();
    $(`#image-${productId}-${index}`).show();
}

