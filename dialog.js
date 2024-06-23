document.addEventListener("DOMContentLoaded", (event) => {
  var formDialog = document.getElementById("formDialog");
  var formArea = document.getElementById("formContent");
  var formTitle = document.getElementById("formTitle");
  var openFormBtn = document.getElementById("openFormBtn");
  var closeFormBtn = document.getElementById("closeFormBtn");
  var contactForm = document.getElementById("contactForm");
  var thankYouMessage = document.getElementById("thankYouMessage");

  // Show the form dialog when the button is clicked

  openFormBtn.onclick = function () {
    formDialog.style.display = "block";
    // Show the main form
    contactForm.style.display = "block";
    formTitle.style.display = "block";
    thankYouMessage.style.display = "none";
  };

  // Hide the form dialog when the close button is clicked
  closeFormBtn.onclick = function () {
    formDialog.style.display = "none";
  };

  // Hide the form dialog when clicking outside of it
  window.onclick = function (event) {
    if (event.target == formDialog) {
      formDialog.style.display = "none";
    }
  };

  // Handle form submission via AJAX
  contactForm.onsubmit = function (event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(contactForm);

    contactForm.style.display = "none";
    formTitle.style.display = "none";
    thankYouMessage.style.display = "block";

    fetch("./send_email.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        console.log("successfully submitted contact form", formData);
        console.log(data); // To see the response from the PHP script
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
      });
  };
});
