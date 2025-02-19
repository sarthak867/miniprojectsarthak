function searchItems() {
    let input = document.getElementById("search").value.toLowerCase();
    let items = document.getElementsByClassName("item-card");

    for (let i = 0; i < items.length; i++) {
        let itemName = items[i].getElementsByTagName("h3")[0].innerText.toLowerCase();
        if (itemName.includes(input)) {
            items[i].style.display = "block";
        } else {
            items[i].style.display = "none";
        }
    }
}
