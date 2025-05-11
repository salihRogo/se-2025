function leaveReview(shop_id) {
  const reviewText = document.getElementById("review-text").value;
  const userId = window.localStorage.getItem("user_id");

  if (!reviewText) {
    toastr.error("Please write a review before submitting.");
    return;
  }

  if (!userId) {
    toastr.error("You must be logged in to leave a review.");
    return;
  }

  const reviewData = {
    shop_id: shop_id,
    user_id: userId,
    comment: reviewText,
  };

  RestClient.post(
    "reviews",
    reviewData,
    function (response) {
      toastr.success("Thank you for your review!");
      document.getElementById("review-form").reset();
    },
    function (error) {
      toastr.error(
        "An error occurred while submitting your review. Please try again."
      );
    }
  );
}

function loadShopReviews(shop_id) {
  RestClient.get("shop/reviews/" + shop_id, function (reviews) {
    const reviewsList = document.getElementById("reviews-list");

    if (reviews.length === 0) {
      reviewsList.innerHTML =
        "<li class='list-group-item'>No reviews yet. Be the first to leave one!</li>";
      return;
    }

    reviews.forEach((review) => {
      const reviewItem = document.createElement("li");
      reviewItem.className = "list-group-item";
      reviewItem.innerHTML = `
        <strong>${review.full_name}</strong> 
        <p>${review.comment}</p>
      `;
      reviewsList.appendChild(reviewItem);
    });
  });
}
