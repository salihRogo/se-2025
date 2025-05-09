var app = $.spapp({
  defaultView: "#home",
  templateDir: "../frontend/pages/",
  pageNotFound: "error_404",
  reloadView: true,
});

app.route({
  view: "single-shop-view",
  load: "single-shop.html",
  onCreate: function () {},
  onReady: function () {
  },
});

app.run();
