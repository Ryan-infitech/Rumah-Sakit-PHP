document.addEventListener("DOMContentLoaded", function () {
    // Add a small delay to ensure elements are fully loaded
    setTimeout(function () {
        // Handle form submission for create and update forms
        const userForms = document.querySelectorAll(".user-form");
        userForms.forEach(function (form) {
            form.addEventListener("submit", function (e) {
                // Regular form submissions continue normally
                // SweetAlert will be triggered by the controller response
            });
        });

        // Handle delete operations
        const deleteForms = document.querySelectorAll(".delete-form");
        deleteForms.forEach(function (form) {
            const deleteButton = form.querySelector(".btn-delete");

            if (deleteButton) {
                deleteButton.addEventListener("click", function (e) {
                    e.preventDefault(); // Prevent any default action

                    Swal.fire({
                        title: "Anda yakin?",
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            } else {
                console.error("Delete button not found in form:", form);
            }
        });

        // Display flash messages using SweetAlert
        const successMessage = document.getElementById("success-message");
        const errorMessage = document.getElementById("error-message");

        if (successMessage && successMessage.value) {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: successMessage.value,
                timer: 3000,
                timerProgressBar: true,
            });
        }

        if (errorMessage && errorMessage.value) {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: errorMessage.value,
                timer: 3000,
                timerProgressBar: true,
            });
        }
    }, 100);
});
