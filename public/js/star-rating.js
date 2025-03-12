/**
 * Star Rating Helper Functions
 *
 * This file provides functionality for the star rating component
 */
document.addEventListener("DOMContentLoaded", function () {
    console.log("Star Rating JS loaded");
    // Initialize all star ratings on the page
    initializeAllStarRatings();

    // Initialize rating modals if they exist
    initializeRatingModals();
});

function initializeAllStarRatings() {
    // Find all star rating containers
    const starRatings = document.querySelectorAll(
        ".star-rating, .rating-stars"
    );
    console.log(`Found ${starRatings.length} star rating containers`);

    starRatings.forEach(function (container) {
        const inputs = container.querySelectorAll('input[type="radio"]');
        const valueDisplay = container.parentElement.querySelector(
            ".rating-value, .selected-rating"
        );

        console.log(`Found ${inputs.length} rating inputs in container`);

        inputs.forEach(function (input) {
            input.addEventListener("change", function () {
                // Update the display
                if (valueDisplay) {
                    valueDisplay.textContent = this.value + " dari 5";
                    console.log(`Rating changed to ${this.value}`);
                }
            });
        });
    });
}

function initializeRatingModals() {
    // Check if we have jQuery and Bootstrap available
    if (typeof $ === "undefined" || typeof $.fn.modal === "undefined") {
        console.log("jQuery or Bootstrap modal not available");
        return;
    }

    console.log("Looking for rating modals");
    const ratingModals = $("#ratingModal, #rateDoktorModal");

    if (ratingModals.length === 0) {
        console.log("No rating modals found on page");
        return;
    }

    console.log(`Found ${ratingModals.length} rating modals`);

    // Initialize the rating modal events
    ratingModals.on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        const modal = $(this);
        const form = modal.find("form");

        console.log("Modal is being shown - triggered by:", button);

        // Extract data from button
        const dokterId = button.data("dokter") || button.data("dokter-id");
        const antrianId = button.data("antrian") || button.data("antrian-id");

        // Get doctor name directly from data attribute
        let dokterNama = button.data("dokter-nama");
        console.log("Initial dokter-nama from data attribute:", dokterNama);

        // If no dokter-nama attribute, try to get from the table row
        if (!dokterNama || dokterNama === "") {
            // Find the cell containing doctor name (4th column - index 3)
            const row = button.closest("tr");
            if (row.length) {
                dokterNama = row.find("td:eq(3)").text();
                console.log(
                    "Retrieved doctor name from table row:",
                    dokterNama
                );
            }
        }

        // Log to debug
        console.log("Rating modal data:", {
            modalId: modal.attr("id"),
            dokterId: dokterId,
            antrianId: antrianId,
            dokterNama: dokterNama,
            hasDokterNameField: modal.find("#dokter_nama").length > 0,
        });

        // Set form field values
        modal.find('input[name="dokter_id"]').val(dokterId);

        if (antrianId) {
            modal.find('input[name="antrian_id"]').val(antrianId);
        }

        // Make sure we find the doctor name field and set its value
        const dokterNameField = modal.find("#dokter_nama");
        if (dokterNama && dokterNameField.length) {
            dokterNameField.val(dokterNama.trim());
            console.log("Set doctor name in field:", dokterNama.trim());
        }

        // Reset form and ratings
        form[0].reset();
        modal.find(".rating-value, .selected-rating").text("0 dari 5");
        modal.find('input[type="radio"]').prop("checked", false);

        // Don't reset the dokter_nama field
        if (dokterNama && dokterNameField.length) {
            dokterNameField.val(dokterNama.trim());
            console.log("Reset complete - doctor name preserved");
        }
    });

    // Add form submission validation
    $("form#ratingForm, form#ratingDoctorForm").on("submit", function (e) {
        const rating = $(this).find('input[name="rating"]:checked').val();
        console.log("Form submission - selected rating:", rating);

        if (!rating) {
            e.preventDefault();
            alert("Silakan pilih rating terlebih dahulu");
            console.log("Form submission blocked - no rating selected");
            return false;
        }

        console.log("Form submission allowed - rating selected");
    });
}
