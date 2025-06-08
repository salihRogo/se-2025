function addFavourite(shopId) {
  const userId = window.localStorage.getItem("user_id");

  if (!userId) {
    toastr.error("You must be logged in to add favourites.");
    return;
  }

  const favouriteData = {
    user_id: userId,
    shop_id: shopId,
  };

  RestClient.post(
    "favourite",
    favouriteData,
    function () {
      toastr.success("Shop added to favourites successfully.");
    },
    function (error) {
      if (error && error.message) {
        toastr.error(error.message);
      } else {
        toastr.error("Failed to add shop to favourites. Please try again.");
      }
    }
  );
}

function loadUserFavourites() {
  const userId = window.localStorage.getItem("user_id");

  if (!userId) {
    toastr.error("You must be logged in to view your favourites.");
    return;
  }

  RestClient.get(
    `favourites/${userId}`,
    function (favourites) {
      const favouritesContainer = document.getElementById(
        "favourites-container"
      );
      favouritesContainer.innerHTML = "";

      if (favourites.length === 0) {
        favouritesContainer.innerHTML = `
          <p class="text-center w-100">You have no favourites yet. Browse shops and add the first one!</p>
        `;
        return;
      }

      favourites.forEach((favourite) => {
        const shopCard = document.createElement("div");
        shopCard.className = "col-lg-4 col-md-6 text-center";
        shopCard.innerHTML = `
                <div class="single-product-item">
                    <div class="shop-image" style="margin-bottom: 30px;">
                        <a href="#single-product"
                            ><img src="${favourite.shop_image}" alt=""
                        /></a>
                    </div>
                    <h3>${favourite.shop_city}</h3>
                    <p class="product-price"><span>${favourite.shop_address}</span>${favourite.shop_name}</p>
                    <button class="cart-btn" onclick="removeFavourite(${favourite.favourite_id});">Remove from Favourites</button>
                </div>
            `;
        favouritesContainer.appendChild(shopCard);
      });
    },
    function (error) {
      toastr.error("Failed to load favourites. Please try again.");
    }
  );
}

function removeFavourite(favouriteId) {
  RestClient.delete(
    `favourite/${favouriteId}`,
    {},
    function () {
      toastr.success("Favourite removed successfully.");
      loadUserFavourites();
    },
    function (error) {
      toastr.error("Failed to remove favourite. Please try again.");
    }
  );
}
