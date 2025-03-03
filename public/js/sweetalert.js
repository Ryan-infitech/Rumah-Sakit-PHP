document.addEventListener("DOMContentLoaded", function () {
    // Add a small delay to ensure elements are fully loaded
    setTimeout(function() {
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
    }, 100);
});