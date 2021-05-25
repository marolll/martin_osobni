// TOGGLE SIDEBAR - must create div with icon inside
// btn - div (btn), sidebar, hidden class for that sidebar, FA menu and close Icon
function sidebarToggle(
  btn,
  sidebar,
  hiddenSidebarClass,
  shownSidebarClass,
  MenuIcon,
  closeIcon
) {
  const icon = btn.children();
  if (sidebar.hasClass(hiddenSidebarClass)) {
    icon.removeClass(MenuIcon);
    icon.addClass(closeIcon);
    sidebar.removeClass(hiddenSidebarClass);

    sidebar.addClass(shownSidebarClass);
    console.log("opening sidebar");
  } else {
    icon.removeClass(closeIcon);
    icon.addClass(MenuIcon);
    sidebar.removeClass(shownSidebarClass);

    sidebar.addClass(hiddenSidebarClass);
    console.log("closing sidebar");
  }
}
