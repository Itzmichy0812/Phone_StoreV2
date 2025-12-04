// Send user contact info to ContactController
document.getElementById("contactForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    const res = await fetch("controllers/ContactController.php?action=create", {
        method: "POST",
        body: formData
    });

    const result = await res.json();

    if (result.success) {
        alert("Message sent successfully!");
        this.reset();
    } else {
        alert("Failed: " + result.message);
    }
});
