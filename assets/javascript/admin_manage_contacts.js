const contactsTableBody = document.querySelector("#contactTable tbody");
const viewModal = new bootstrap.Modal(document.getElementById("viewContactModal"));
const modalSubject = document.getElementById("contactSubject");
const modalMessage = document.getElementById("contactMessage");

// Load contact data
async function fetchContacts() {
    try {
        const res = await fetch("controllers/ContactController.php?action=list");
        const result = await res.json();

        if (result.success) {
            renderTable(result.data);
        } else {
            console.error(result.message);
        }
    } catch (err) {
        console.error("Failed to fetch contacts:", err);
    }
}

// Render contacts table
function renderTable(data) {
    contactsTableBody.innerHTML = "";

    data.forEach((item, index) => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${item.name}</td>
            <td>${item.email}</td>

            <td>
                <button class="btn btn-sm btn-outline-primary btn-view" data-id="${item.id}">
                    View
                </button>
            </td>

            <td>${item.created_at}</td>

            <td>
                <select class="form-select form-select-sm contact-status" data-id="${item.id}">
                    <option value="unread"  ${item.status === "unread" ? "selected" : ""}>Unread</option>
                    <option value="read"    ${item.status === "read" ? "selected" : ""}>Read</option>
                    <option value="replied" ${item.status === "replied" ? "selected" : ""}>Replied</option>
                </select>
            </td>

            <td>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">
                    Delete
                </button>
            </td>
        `;

        contactsTableBody.appendChild(row);
    });
}

// Table buttons event (view and delete)
contactsTableBody.addEventListener("click", async (e) => {
    const id = e.target.dataset.id;

    // View button, click it will show subject and message popu[]
    if (e.target.classList.contains("btn-view")) {
        try {
            const res = await fetch(`controllers/ContactController.php?action=get&id=${id}`);
            const result = await res.json();

            if (result.success) {
                modalSubject.textContent = result.data.subject;
                modalMessage.textContent = result.data.message;
                viewModal.show();
            } else {
                alert(result.message || "Failed to load contact details");
            }
        } catch (err) {
            console.error("Error loading contact:", err);
        }
    }

    // Delete button
    if (e.target.classList.contains("btn-delete")) {
        if (!confirm("Delete this contact?")) return;

        const formData = new FormData();
        formData.append("id", id);

        try {
            const res = await fetch("controllers/ContactController.php?action=delete", {
                method: "POST",
                body: formData
            });
            const result = await res.json();

            if (result.success) fetchContacts();
            else alert(result.message);
        } catch (err) {
            console.error("Failed to delete contact:", err);
        }
    }
});

// Status dropdown box event
contactsTableBody.addEventListener("change", async (e) => {
    if (e.target.classList.contains("contact-status")) {
        const id = e.target.dataset.id;
        const status = e.target.value;

        const formData = new FormData();
        formData.append("id", id);
        formData.append("status", status);

        try {
            const res = await fetch("controllers/ContactController.php?action=updateStatus", {
                method: "POST",
                body: formData
            });
            const result = await res.json();

            if (!result.success) {
                alert(result.message || "Failed to update status");
            }
        } catch (err) {
            console.error("Failed to update status:", err);
        }
    }
});

// Initial load
fetchContacts();
