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
                var productHtml = `
                    <div class="col-" style="margin-right: 30px;">
                        <div class="card w-56 mb-4" style="background-color: #FEFAE0; border-radius: 5px; border-color: transparent;">      
                            <figure>
                                <a href="/products/add_to_cart/${product.product_id}">
                                    <img src="/imgs/${images[0].trim()}" alt="${product.name}" data-product-id="${product.product_id}" style="border-radius: 5px 5px 0px 0px; height: 224px;">
                                </a>
                            </figure>
                            <div class="card-body" style="padding: 0px;">
                                <h2 class="card-title" style="color: #B99470; font-weight: 600; font-family: Poppins, sans-serif; font-size: 14px; margin-top: 10px; margin-bottom: 2px;">${product.name}</h2>
                                <p style="color: #A9B388; font-family: Poppins, sans-serif; font-size: 16px; font-weight: 600;"><strong>&#8369;</strong> ${product.price}</p>
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


