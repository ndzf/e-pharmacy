function errorAlert(message) {
    Swal.fire({
        position: "bottom-right",
        showConfirmButton: false,
        html: `<i class="fas fa-triangle-exclamation text-danger me-2"></i> ${message}`,
        timer: 5000,
        timerProgressBar: true,
    });
}

function successAlert(message) {
    Swal.fire({
        position: "bottom-right",
        showConfirmButton: false,
        html: `<i class="fas fa-bell text-success me-2"></i> ${message}`,
        timer: 5000,
        timerProgressBar: true,
    });
}