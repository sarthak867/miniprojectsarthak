function searchItems() {
    let input = document.getElementById("search").value.toLowerCase();
    let cards = document.getElementsByClassName("item-card");

    for (let card of cards) {
        let itemName = card.getElementsByTagName("h3")[0].innerText.toLowerCase();
        if (itemName.includes(input)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    }
}