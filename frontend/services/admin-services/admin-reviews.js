var AdminManageReviews = {
  displayShopReviews(shop_id) {
    window.location.hash = "#admin-manage-reviews";
    RestClient.get(`admin/shop/reviews/${shop_id}`, function (reviews) {
      const reviewsContainer = document.getElementById("admin-reviews-container");
      reviewsContainer.innerHTML = "";

      if (!reviews || reviews.length === 0) {
        reviewsContainer.innerHTML = `
          <div class="alert alert-info text-center my-4">
            There are currently no reviews for this shop.
          </div>
        `;
        return;
      }

      reviews.forEach((review) => {
        const reviewDiv = document.createElement("div");
        reviewDiv.className = "single-user-item";
        reviewDiv.innerHTML = `
          <table class="user-profile-table">
            <tr>
              <th class="label-cell">User</th>
              <td class="value-cell editable" data-field="name">
                <span class="display-mode">${review.full_name}</span>
              </td>
            </tr>
            <tr>
              <th class="label-cell">Comment</th>
              <td class="value-cell editable" data-field="address">
                <span class="display-mode">${review.comment}</span>
              </td>
            </tr>
            <tr class="actions-row">
              <td colspan="2">
                <div class="action-buttons">
                  <button class="btn delete-btn" onclick="deleteReview(${review.id}, ${review.shop_id})">
                    <i class="fas fa-trash-alt"></i> Delete
                  </button>
                </div>
              </td>
            </tr>
          </table>
          <br>
        `;
        reviewsContainer.appendChild(reviewDiv);
      });
    });
  },
};

function deleteReview(review_id, shop_id) {
  // Confirm deletion with the user
  if (confirm("Are you sure you want to delete this review?")) {
    // Send DELETE request to the backend
    RestClient.delete(
      `admin/review/${review_id}`,
      review_id,
      function (response) {
        // Notify the user of successful deletion
        toastr.success("Review deleted successfully!");

        // Refresh the user table
        AdminManageReviews.displayShopReviews(shop_id);
      },
      function (error) {
        // Handle errors
        toastr.error("Failed to delete the user. Please try again.");
      }
    );
  }
}