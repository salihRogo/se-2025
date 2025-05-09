function display_shops_on_home() {
  RestClient.get("home/shops", function (data) {
    const homeShopsContainer = document.getElementById("home-shops");
    homeShopsContainer.innerHTML = "";

    data.forEach((shop) => {
      const shopDiv = document.createElement("div");
      shopDiv.className = "col-lg-4 col-md-6 text-center";
      shopDiv.innerHTML = `
                <div class="single-product-item">
                    <div class="shop-image" style="margin-bottom: 30px;">
                        <a href="#single-product"
                            ><img src="${shop.image_url}" alt=""
                        /></a>
                    </div>
                    <h3>${shop.city}</h3>
                    <p class="product-price"><span>${shop.address}</span>${shop.name}</p>
                    <a href="#single-product" class="cart-btn">See more</a>
                </div>
            `;
      homeShopsContainer.appendChild(shopDiv);
    });
  });
}

function display_all_shops() {
  RestClient.get("shops", function (data) {
    const shopsContainer = document.getElementById("shops-container");
    shopsContainer.innerHTML = "";

    data.forEach((shop) => {
      const shopDiv = document.createElement("div");
      shopDiv.className = "col-lg-4 col-md-6 text-center";
      shopDiv.innerHTML = `
                <div class="single-product-item">
                    <div class="shop-image" style="margin-bottom: 30px;">
                        <a href="#single-product"
                            ><img src="${shop.image_url}" alt=""
                        /></a>
                    </div>
                    <h3>${shop.city}</h3>
                    <p class="product-price"><span>${shop.address}</span>${shop.name}</p>
                    <a href="#single-product" class="cart-btn">See more</a>
                </div>
            `;
      shopsContainer.appendChild(shopDiv);
    });
  });
}

function filterShops(city) {
  const buttons = document.querySelectorAll(".filter-btn");
  buttons.forEach((button) => button.classList.remove("active"));

  if (city) {
    const activeButton = Array.from(buttons).find(
      (btn) => btn.textContent === city
    );
    if (activeButton) activeButton.classList.add("active");
  }

  const shopsContainer = document.getElementById("shops-container");
  const allShops = shopsContainer.querySelectorAll(".single-product-item");

  allShops.forEach((shop) => {
    const shopCity =
      shop.getAttribute("data-city") ||
      shop.querySelector("h3").textContent.trim();
    if (!city || shopCity === city) {
      shop.style.display = "block";
    } else {
      shop.style.display = "none";
    }
  });
}
