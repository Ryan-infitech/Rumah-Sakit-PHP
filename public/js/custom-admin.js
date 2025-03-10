$(document).ready(function () {
    // Fix for sidebar dropdown menus
    $(".nav-item .nav-link").each(function () {
        var $this = $(this);
        var $targetCollapse = $($this.data("target"));

        // If current page matches any item in the dropdown, keep it expanded
        if ($targetCollapse.find(".collapse-item.active").length > 0) {
            $this.attr("aria-expanded", "true");
            $targetCollapse.addClass("show");
        }
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
