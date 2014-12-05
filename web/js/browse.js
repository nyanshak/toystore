$(function() {
    var $categories = $("#catfilter");
    $.ajax({
        url: "/php/categories.php",
        type: "post",
        dataType: "json",
        success: function(data) {
            if (!data["success"]) {
                console.log(data["error"]);
            }
            else {
                console.log(data);
                var categories = data["categories"];
                $.each(categories, function(i, category) {
                    $categories.append("<option>" + category.Name + "</option>");
                });
                catsReady();
            }
        },
        error: function(xhr) {
                console.log("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
        }	
    });
});

function catsReady() {
    var $categories = $("#catfilter");
    var $minPrice = $("#minPrice");
    var $maxPrice = $("#maxPrice");
    var $search = $("#search");
    var $submitBtn = $("#submitBtn");
    var selectDefault = $("#selectDefault").text();
    $categories.val(selectDefault);
    getProducts({category: selectDefault});
    $categories.change(function() {
        getProductsCaller($("#catfilter option:selected").val(), $minPrice.val(), 
                $maxPrice.val(), $search.val());
    });
    $minPrice.change(function() {
        getProductsCaller($("#catfilter option:selected").val(), $minPrice.val(), 
                $maxPrice.val(), $search.val());
    });
    $maxPrice.change(function() {
        getProductsCaller($("#catfilter option:selected").val(), $minPrice.val(), 
                $maxPrice.val(), $search.val());
    });
    $search.change(function() {
        getProductsCaller($("#catfilter option:selected").val(), $minPrice.val(), 
                $maxPrice.val(), $search.val());
    });
    $submitBtn.click(function() {
        getProductsCaller($("#catfilter option:selected").val(), $minPrice.val(), 
                $maxPrice.val(), $search.val());
    });
}

function getProductsCaller(category, minPrice, maxPrice, keyword) {
    if ((minPrice !== "" && !/^[0-9]+(.[0-9]+)?$/.test(minPrice)) || (maxPrice !== "" && !/^[0-9]+(.[0-9]+)?$/.test(maxPrice))) {
        alert("Incorrect max/min price! Please enter a valid number.");
    }
    else if (minPrice !== "" && maxPrice !== "" && Number(minPrice) >= Number(maxPrice)) {
        alert("Min price >= Max price!");
    }
    else {
        getProducts({
            category: category,
            pricelower: minPrice,
            priceupper: maxPrice,
            name: keyword,
            description: keyword,
            keywords: true,
            split: true
        });
    }
}

function getProducts(data) {
    var $products = $("#products");
    $.ajax({
        url: "/php/products.php",
        data: data,
        type: "post",
        dataType: "json",
        success: function(data) {
            if (!data["success"]) {
                console.log(data["error"]);
            }
            else {
                console.log(data);
                $products.empty();
                $products.append('<tr class="border"><td class="hide">Category</td><td>Product</td><td>Description</td><td>Price</td><td>Inventory</td><td>Add to Cart</td></tr>');
                var products = data["products"];
                $.each(products, function(i, product) {
                    $products.append('<tr><td class="hide">' + product.Id + '</td><td class="hide">' + product.Category + "</td><td><img src=" + product.Picture + " alt='Product Picture' /><br />" + product.Name + "</td><td>" 
                            + product.Description + "</td><td>$" + product.Price + "</td><td>Qty: " + product.Inventory + '</td><td><button class="cartAdd">Add to Cart</button></td></tr>');
                });
                $(".hide").hide();
                if ($products.length > 0) {
                    addToCart();
                }
            }
        },
        error: function(xhr) {
                console.log("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
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
            var $productId = $qty.prev().prev().prev().prev().prev();
            var productId = $productId.text();
            var desiredQty = prompt("Enter quantity to add to cart:");
            if (!/^[1-9]+[0-9]*$/.test(desiredQty)) {
                alert("Incorrect quantity! Please enter a valid number")
            }
            else if (qty - desiredQty < 0) {
                alert("Quantity entered greater than available stock!");
            }
            else {
                $.ajax({
                    url: "/php/addtocart.php",
                    data: {
                        pid: productId,
                        qty: desiredQty
                    },
                    type: "post",
                    dataType: "json",
                    success: function(data) {
                        // Reply indicates if user is not logged in so we need to alert user to login
                        if (data["reply"] === "success") {
                            alert("Item successfully added to cart!");
                        }
                        else if (data["reply"] === "not_logged_in") {
                            alert("You must login before adding to cart.");
                        }
                    },
                    error: function(xhr) {
                        console.log("Oops! Something went wrong: " + xhr.status + " " + xhr.statusText);
                    }
                });
            }
        }
    });
}