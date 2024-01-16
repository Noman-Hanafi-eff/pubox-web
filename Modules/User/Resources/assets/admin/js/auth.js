import jQuery from "jquery";

window.$ = window.jQuery = jQuery;

$("[data-loading]").on("click", (e) => {
    let button = $(e.currentTarget);

    if (button.is("i")) {
        button = button.parent();
    }

    button
        .addClass("btn-loading")
        .attr("disabled", "disabled")
        .parents("form")
        .trigger("submit");
});
