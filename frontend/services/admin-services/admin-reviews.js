var AdminManageReviews = {
  displayShopReviews(shop_id) {
    window.location.hash = "#admin-manage-reviews";
    RestClient.get(`admin/shop/reviews/${shop_id}`, function (reviews) {
        const reviewsContainer = document.getElementById("admin-reviews-container");
        reviewsContainer.innerHTML = "";

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
                        <button class="btn delete-btn" onclick="deleteReview('${review.id}')">
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
