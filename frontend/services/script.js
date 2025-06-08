var app = $.spapp({
  defaultView: "#home",
  templateDir: "../frontend/pages/",
  pageNotFound: "error_404",
  reloadView: true,
});

app.route({
  view: "single-shop-view",
  load: "single-shop.html",
  onReady: function() {
    display_single_shop(shop_id = null);
  }
});

app.run();
