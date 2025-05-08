function display_shops_on_home() {
    RestClient.get("home/shops", function(data) {
        const homeShopsContainer = document.getElementById("home-shops");
        homeShopsContainer.innerHTML = "";

        data.forEach((shop) => {
            const shopDiv = document.createElement("div");
            shopDiv.className = "col-lg-4 col-md-6 text-center";
            shopDiv.innerHTML = `
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="#single-product"
                            ><img src="assets/img/products/product-img-3.jpg" alt=""
                        /></a>
                    </div>
                    <h3>${shop.city}</h3>
                    <p class="product-price"><span>${shop.address}</span>${shop.name}</p>
                    <a href="cart.html" class="cart-btn">See more</a>
                </div>
            `;
            homeShopsContainer.appendChild(shopDiv);
        });
    });
};

function display_all_shops() {
    RestClient.get("shops", function(data) {
        const shopsContainer = document.getElementById("shops");
        shopsContainer.innerHTML = "";

        data.forEach((shop) => {
            const shopDiv = document.createElement("div");
            shopDiv.className = "col-lg-4 col-md-6 text-center";
            shopDiv.innerHTML = `
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="#single-product"
                            ><img src="assets/img/products/product-img-3.jpg" alt=""
                        /></a>
                    </div>
                    <h3>${shop.city}</h3>
                    <p class="product-price"><span>${shop.address}</span>${shop.name}</p>
                    <a href="cart.html" class="cart-btn">See more</a>
                </div>
            `;
            shopsContainer.appendChild(shopDiv);
        });
    });
}
