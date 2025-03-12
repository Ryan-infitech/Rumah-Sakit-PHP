/**
 * Star Rating Functionality
 */
document.addEventListener("DOMContentLoaded", function () {
    // Initialize star rating UI
    function initStarRating() {
        const ratingInputs = document.querySelectorAll(".rating-stars input");
        const selectedRating = document.querySelector(".selected-rating");

        if (!ratingInputs.length) return;

        ratingInputs.forEach((input) => {
            input.addEventListener("change", function () {
                if (selectedRating) {
                    selectedRating.textContent = this.value + "/5";
                }

                // Update star visualization
                const stars = document.querySelectorAll(".rating-stars label");
                const selectedValue = parseInt(this.value);

                stars.forEach((star, index) => {
                    const starValue = 5 - index; // Reverse order of labels
                    if (starValue <= selectedValue) {
                        star.classList.add("active");
                    } else {
                        star.classList.remove("active");
                    }
                });
            });
        });
    }

    // Listen for modal show events
    const ratingModal = document.getElementById("ratingModal");
    if (ratingModal) {
        ratingModal.addEventListener("shown.bs.modal", function () {
            initStarRating();
        });
    } else {
        // Initialize directly if no modal
        initStarRating();
    }
});
