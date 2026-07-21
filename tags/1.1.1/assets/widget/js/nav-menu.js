jQuery(function ($) {
  "use strict";

  initMobileMenu();

  if (
    window.elementorFrontend &&
    window.elementorFrontend.hooks &&
    typeof window.elementorFrontend.hooks.addAction === "function"
  ) {
    window.elementorFrontend.hooks.addAction("frontend/element_ready/global", function () {
      initMobileMenu();
    });
  }


  function initMobileMenu() {
    // Avoid re-binding
    $(".wkit-mobile-menu-btn").off("click").on("click", function () {
      $(".wkit-mobile-menu").addClass("show");
      $(".wkit-mobile-menu-overlay").addClass("show");
    });

    $(".wkit-mobile-menu-close, .wkit-mobile-menu-overlay").off("click").on("click", function () {
      $(".wkit-mobile-menu").removeClass("show");
      $(".wkit-mobile-menu-overlay").removeClass("show");
    });

    // Mobile submenu toggle (semua level)
    $(document).off("click", ".wkit-mobile-nav li.wkit-dropdown");

    $(document).on("click", ".wkit-mobile-nav li.wkit-dropdown", function (e) {
      e.stopPropagation();

      const $submenuUL = $(this).children("ul");
      const $submenuDIV = $(this).children("div");

      // Tutup semua sibling UL saja
      $(this).siblings(".wkit-dropdown").children("ul").slideUp();
      // Tutup semua sibling DIV saja
      $(this).siblings(".wkit-dropdown").children("div").slideUp();

      // Toggle submenu yg diklik
      if ($submenuUL.length) $submenuUL.slideToggle();
      if ($submenuDIV.length) $submenuDIV.slideToggle();
    });


    
    const mainMenu = $("#wkit-main-navbar").html();
    if (mainMenu) {
      $(".wkit-mobile-nav").html(mainMenu);
    }

    $("[data-background]").each(function () {
      const bg = $(this).data("background");
      if (bg) {
        $(this).css("background-image", "url(" + bg + ")");
      }
    });
  }
});
