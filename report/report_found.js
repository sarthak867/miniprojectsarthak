document.getElementById("found-item-form").addEventListener("submit", function(event) {
    let itemName = document.getElementById("item-name").value;
    let contactInfo = document.getElementById("contact-info").value;

    if (itemName.trim() === "" || contactInfo.trim() === "") {
        alert("Item name and contact information are required!");
        event.preventDefault();
    }
});
