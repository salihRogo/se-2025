function displayLoyaltyPoints(user_id) {
  window.location.hash = "#coupon";
  RestClient.get(`user/${user_id}`, function (user) {
    loyaltyPoints = user.loyalty_points;

    const element = document.getElementById("number-of-loyalty-points");
    element.innerHTML = `
    Number of loyalty points: ${loyaltyPoints}
    `;
  });
}
function displayAllCoupons(user_id) {
  RestClient.get(`coupons/${user_id}`, function (coupons) {
    const container = document.getElementById("user-coupons-list");
    if (!container) return;

    container.innerHTML = ""; // Clear previous coupons

    if (coupons && coupons.length > 0) {
      coupons.forEach((coupon) => {
        const couponDiv = document.createElement("div");
        couponDiv.className = "coupon-card mb-3";
        couponDiv.innerHTML = `
          <div class="coupon-header">
            <h2>COUPON</h2>
          </div>
          <div class="coupon-value">
            <h1 class="coupon-amount">$20</h1>
          </div>
          <div class="coupon-details">
            <p class="brand">Buy In Any Of Our Shops</p>
            <p class="text">Valid Through:</p>
            <p class="expiration">${coupon.expires_at || "N/A"}</p>
          </div>
        `;
        container.appendChild(couponDiv);
      });
    } else {
      container.innerHTML = "<p>No coupons available.</p>";
    }
  });
}
