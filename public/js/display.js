// $(document).ready(function() {
//     $.ajax({
//         url: '/api/products',
//         method: 'GET',
//         dataType: 'json',
//         success: function(data) {
//             var productsContainer = $('#products-container');
//             data.forEach(function(product) {
//                 var images = product.images.split(',');
//                 var imagesHtml = '';
//                 var radioButtonsHtml = '';

//                 images.forEach(function(image, index) {
//                     var isChecked = index === 0 ? 'checked' : '';
//                     imagesHtml += `
//                         <div class="product-image" id="image-${product.product_id}-${index}" style="display: ${index === 0 ? 'block' : 'none'};">
//                             <img src="/imgs/${image.trim()}" class="card-img-top" alt="${product.name}">
//                         </div>
//                     `;
//                     radioButtonsHtml += `
//                         <input type="radio" name="image-${product.product_id}" value="${index}" ${isChecked} onclick="showImage(${product.product_id}, ${index})">
//                     `;
//                 });

//                 var productHtml = `
//                     <div class="col-md-4">
//                         <div class="card mb-4">
//                             ${imagesHtml}
//                             <div class="card-body">
//                                 <div class="image-selection">
//                                     ${radioButtonsHtml}
//                                 </div>
//                                 <h5 class="card-title">${product.name}</h5>
//                                 <p class="card-text">${product.description}</p>
//                                 <p class="card-text"><strong>Price:</strong> ${product.price}</p>
//                             </div>
//                         </div>
//                     </div>
//                 `;
//                 productsContainer.append(productHtml);
//             });
//         },
//         error: function(error) {
//             console.log('Error fetching products:', error);
//         }
//     });
// });

// function showImage(productId, index) {
//     $(`div[id^='image-${productId}']`).hide();
//     $(`#image-${productId}-${index}`).show();
// }


$(document).ready(function() {
    $.ajax({
        url: '/api/products',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var productsContainer = $('#products-container');
            data.forEach(function(product) {
                var images = product.images.split(',');
                var imagesHtml = '';
                imagesHtml += `
                    <div class="product-image">
                        <a href="/products/add_to_cart/${product.product_id}">
                            <img src="/imgs/${images[0].trim()}" class="card-img-top" alt="${product.name}" data-product-id="${product.product_id}">
                        </a>
                    </div>
                `;

                var productHtml = `
                    <div class="col-md-4">
                        <div class="card mb-4">
                            ${imagesHtml}
                            <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text"><strong>Price:</strong> ${product.price}</p>
                            </div>
                        </div>
                    </div>
                `;
                productsContainer.append(productHtml);
            });
        },
        error: function(error) {
            console.log('Error fetching products:', error);
        }
    });
});

