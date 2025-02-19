document.addEventListener("DOMContentLoaded", function() {
    const approveButtons = document.querySelectorAll(".approve-btn");

    approveButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            const confirmAction = confirm("Are you sure you want to approve this claim?");
            if (!confirmAction) {
                event.preventDefault();
            }
        });
    });
});
