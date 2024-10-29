let actionUrl = "";

function openModal(url) {
  actionUrl = url;
  document.getElementById("confirmationModal").style.display = "block";
}

function closeModal() {
  document.getElementById("confirmationModal").style.display = "none";
}

function confirmAction() {
  closeModal();
  if (actionUrl) {
    window.location.href = actionUrl;
  }
}

let userProfile = document.querySelector(".userProfile");
let buttons = document.querySelectorAll(".button");

if (userProfile.display == "flex") {
  buttons.style.display = "none !important";
}
