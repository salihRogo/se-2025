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
                        <a href="javascript:void(0);" onclick="display_single_shop(${shop.id})"
                            ><img src="${shop.image_url}" alt=""
                        /></a>
                    </div>
                    <h3>${shop.city}</h3>
                    <p class="product-price"><span>${shop.address}</span>${shop.name}</p>
                    <a href="javascript:void(0);" class="cart-btn" onclick="display_single_shop(${shop.id})">See more</a>
                </div>
            `;
      homeShopsContainer.appendChild(shopDiv);
    });
  });
}

// Store all shops data for filtering
let allShopsData = [];

function display_all_shops() {
  RestClient.get("shops", function (data) {
    allShopsData = data; // Store data for search/filter
    renderShops(data);
  });
}

function renderShops(shops) {
  const shopsContainer = document.getElementById("shops-container");
  const noResults = document.getElementById("no-results");

  shopsContainer.innerHTML = "";

  if (shops.length === 0) {
    noResults.style.display = "block";
    return;
  } else {
    noResults.style.display = "none";
  }

  shops.forEach((shop) => {
    const shopDiv = document.createElement("div");
    shopDiv.className = "col-lg-4 col-md-6 text-center";
    shopDiv.setAttribute("data-city", shop.city);
    shopDiv.setAttribute("data-name", shop.name.toLowerCase());
    shopDiv.setAttribute("data-address", shop.address.toLowerCase());
    shopDiv.innerHTML = `
      <div class="single-product-item">
        <div class="shop-image" style="margin-bottom: 30px;">
          <a href="javascript:void(0);" onclick="display_single_shop(${shop.id})">
            <img src="${shop.image_url}" alt="" />
          </a>
        </div>
        <h3>${shop.city}</h3>
        <p class="product-price"><span>${shop.address}</span>${shop.name}</p>
        <a href="javascript:void(0);" class="cart-btn" onclick="display_single_shop(${shop.id})">See more</a>
      </div>
    `;
    shopsContainer.appendChild(shopDiv);
  });
}

function searchShops() {
  const searchTerm = document
    .getElementById("shop-search")
    .value.toLowerCase()
    .trim();

  if (searchTerm === "") {
    // If search is empty, show all shops
    renderShops(allShopsData);
    return;
  }

  // Filter shops based on search term
  const filteredShops = allShopsData.filter((shop) => {
    return (
      shop.name.toLowerCase().includes(searchTerm) ||
      shop.city.toLowerCase().includes(searchTerm) ||
      shop.address.toLowerCase().includes(searchTerm) ||
      (shop.description && shop.description.toLowerCase().includes(searchTerm))
    );
  });

  renderShops(filteredShops);

  // Clear any active filter buttons since we're now in search mode
  const filterButtons = document.querySelectorAll(".filter-btn");
  filterButtons.forEach((btn) => btn.classList.remove("active"));
}

function clearSearch() {
  document.getElementById("shop-search").value = "";
  renderShops(allShopsData);
}

function filterShops(city) {
  // Clear search when filtering
  document.getElementById("shop-search").value = "";

  const buttons = document.querySelectorAll(".filter-btn");
  buttons.forEach((button) => button.classList.remove("active"));

  if (city) {
    const activeButton = Array.from(buttons).find(
      (btn) => btn.textContent === city
    );
    if (activeButton) activeButton.classList.add("active");

    // Filter from original data
    const filteredShops = allShopsData.filter((shop) => shop.city === city);
    renderShops(filteredShops);
  } else {
    // Show all shops
    renderShops(allShopsData);
  }
}

function display_single_shop(shop_id) {
  if (shop_id === null) {
    shop_id = localStorage.getItem("shop_id");
  }

  if (
    localStorage.getItem("shop_id") !== shop_id ||
    localStorage.getItem("shop_id") === null
  ) {
    window.localStorage.setItem("shop_id", shop_id);
  }

  localStorage.setItem("shop_id", shop_id);
  window.location.hash = "#single-shop-view";
  RestClient.get("shops/" + shop_id, function (data) {
    shop = data;
    const singleShop = document.getElementById("single-shop-div");
    singleShop.innerHTML = `
      <div class="container">
        <div class="row">
        <div class="col-md-5">
          <div class="single-product-img">
          <img src="${shop.image_url}" alt="" />
          </div>
        </div>
        <div class="col-md-7">
          <div class="shop-details">
          <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
          <h2 style="margin: 0;">${shop.name}</h2>
          <a href="javascript:void(0);" class="cart-btn" onclick="addFavourite(${shop.id});">Add To Favourites</a>
          </div>
          <p><strong>Address:</strong> ${shop.address}</p>
          <p><strong>City:</strong> ${shop.city}</p>
          <p><strong>Contact Number:</strong> ${shop.contact_number}</p>
          <p><strong>Opening Hours:</strong> ${shop.opens_at} - ${shop.closes_at}</p>
          <p>
            <strong>Description:</strong> 
            ${shop.description}
          </p>
          </div>
        </div>
        </div>
        <br>
      </div>
      <div class="mx-auto" style="width: 65%;"><hr></div>
      <div class="mx-auto" style="width: 65%; margin-top: 50px;">
        <div class="text-center">
          <h4>Reserve a Spot</h4>
        </div>
        <br>
        <div>
          <form id="reservation-form" class="d-flex justify-content-between align-items-start">
            <!-- Left Section: Number of Guests -->
            <div class="form-group text-center" style="flex: 1; padding: 0 15px;">
              <label for="number_of_guests"><b>Number of Guests:</b></label>
              <div class="my-2">
                <a href="javascript:void(0);" class="shop-btn filter-btn d-inline-block mx-1" onclick="setGuestNumber(2)">2</a>
                <a href="javascript:void(0);" class="shop-btn filter-btn d-inline-block mx-1" onclick="setGuestNumber(3)">3</a>
                <a href="javascript:void(0);" class="shop-btn filter-btn d-inline-block mx-1" onclick="setGuestNumber(4)">4</a>
              </div>
              <input type="number" id="number_of_guests" class="form-control mx-auto mt-2" placeholder="Enter custom number" min="1" style="width: 93%; text-align: center; height: 50px;" />
            </div>

            <!-- Right Section: Date and Time Pickers -->
            <div class="form-group text-center" style="flex: 1; padding: 0 15px;">
              <div class="mb-3">
                <label for="reservation-date"><b>Date:</b></label>
                <input type="date" id="reservation-date" class="form-control mx-auto" style="width: 93%; height: 50px;" />
              </div>
              <div>
                <label for="reservation-time"><b>Time:</b></label>
                <input type="time" id="reservation-time" class="form-control mx-auto" style="width: 93%; height: 50px;" />
              </div>
            </div>
          </form>
          <div class="text-center mt-4">
            <button type="button" class="cart-btn" onclick="confirmReservation(${shop.id})">Confirm</button>
          </div>
        </div>
      </div>
      <div class="mx-auto" style="width: 65%; margin-top: 50px;">
        <div class="text-center">
          <h4>Leave a Review</h4>
        </div>
        <form id="review-form" class="mt-4" style="flex: 1; padding: 0 20px;">
          <div class="form-group">
            <label for="review-text"><strong>Your Review:</strong></label>
            <textarea id="review-text" class="form-control" rows="4" placeholder="Write your review here..." required></textarea>
          </div>
          <div class="text-center mt-3">
            <button type="button" class="cart-btn" onclick="leaveReview(${shop.id})">Submit Review</button>
          </div>
        </form>
      </div>
      <div id="reviews-container" class="mt-4" style="flex: 1; padding: 0 315px;">
            <label for="review-text"><strong>Other Reviews:</strong></label>
        <ul id="reviews-list" class="list-group"></ul>
      </div>
    `;
    loadShopReviews(shop_id);
  });
}

function setGuestNumber(number) {
  document.getElementById("number_of_guests").value = number;
}
