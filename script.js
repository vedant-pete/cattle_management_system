// script.js
document
  .querySelector(".search-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    var searchTerm = document.querySelector(".search-input").value;
    console.log("Searching for:", searchTerm);
    // Add your search functionality here
  });
