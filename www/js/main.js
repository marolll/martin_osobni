const sidebarToggler = $("#sidebar-toggler");
const navbar = $("#navbar");

// Document Ready
jQuery(function () {
  sidebarToggler.on("click", function () {
    sidebarToggle(
      sidebarToggler,
      navbar,
      "hidden-sidebar",
      "shown-sidebar",
      "fa-bars",
      "fa-times"
    );
  });
});
