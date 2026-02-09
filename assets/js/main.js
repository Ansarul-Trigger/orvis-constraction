document.addEventListener("DOMContentLoaded", function () {

  // Show success message if URL contains ?success=1
  const params = new URLSearchParams(window.location.search);

  if (params.get("success") === "1") {
    const successMessage = document.getElementById("success-message");
    if (successMessage) {
      successMessage.style.display = "block";
    }
  }

});
