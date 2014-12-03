$(function() {
    var $categories = $("#catfilter");
    $.ajax({
        url: "/php/categories.php",
        type: "post",
        dataType: "json",
        success: function(categories) {
            $.each(categories, function(i, category) {
                $categories.append("<option>" + category.Name + "</option>");
            });
            catsReady();
        },
        error: function(xhr) {
                alert("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
        }	
    });
});

function catsReady() {
    var $categories = $("#catfilter");
    $categories.val("New");
    getProducts({category: "New"});
    $categories.change(function() {
        getProducts({category: $("#catfilter option:selected").text()});
    });
    var $search = $("#search");
    var $searchBtn = $("#searchBtn");
    $searchBtn.click(function() {
        getProducts({
            name: $search.val(),
            description: $search.val()
        });
    });
}

function getProducts(data) {
    var $products = $("#products");
    $.ajax({
        url: "/php/products.php",
        data: data,
        type: "post",
        dataType: "json",
        success: function(products) {
            $products.empty();
            $products.append('<tr class="border"><td>Category</td><td>Product</td><td>Description</td><td>Price</td><td>Inventory</td><td>Add to Cart</td></tr>');
            $.each(products, function(i, product) {
                $products.append('<tr><td class="hide">' + product.Id + "</td><td>" + product.Category + "</td><td><img src=" + product.Picture + " alt='Product Picture' /><br />" + product.Name + "</td><td>" 
                        + product.Description + "</td><td>$" + product.Price + "</td><td>Qty: " + product.Inventory + '</td><td><button class="cartAdd">Add to Cart</button></td></tr>');
            });
            $(".hide").hide();
            if ($products.length > 0) {
                addToCart();
            }
        },
        error: function(xhr) {
                alert("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
        }	
    });
}

function addToCart() {
    var $cartAdd = $(".cartAdd");
    $cartAdd.click(function() {
        // Get DOM parent info to get ProductId, Qty, and Price
        var $qty = $(this).parent().prev();
        var qty = $qty.text().match(/\d+/);
        if (qty <= 0) {
            alert("This item is currently not in stock. Please check back later.");
        }
        else {
            var $price = $qty.prev();
            var price = $price.text().match(/\d+(\.\d+)?/);
            var $productId = $price.prev().prev().prev().prev();
            var productId = $productId.text();
            var desiredQty = prompt("Enter quantity to add to cart:");
            if (qty - desiredQty < 0) {
                alert("Quantity entered greater than available stock!");
            }
            else {
                $.ajax({
                    url: "/php/addtocart.php",
                    data: {
                        pid: productId,
                        qty: desiredQty,
                        price: price
                    },
                    type: "post",
                    dataType: "json",
                    success: function(reply) {
                        // Reply indicates if user is not logged in so we need to alert user to login
                        // We also need to check inventory and ensure it is > 0.
                    },
                    error: function(xhr) {
                        alert("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
                    }
                });
            }
        }
    });
}