const qnaTableBody = document.querySelector("#qnaTable tbody");
const qnaForm = document.getElementById("qnaForm");
const qnaModal = new bootstrap.Modal(document.getElementById("qnaModal"));
const modalTitle = document.getElementById("modalTitle");
const addNewBtn = document.getElementById("addNewBtn");

let qnaData = [];

// Render Q&A table
function renderTable() {
  qnaTableBody.innerHTML = "";
  qnaData.forEach((item, index) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${item.question}</td>
      <td>${item.answer}</td>
      <td>
        <button class="btn btn-sm btn-warning btn-edit" data-index="${index}">Edit</button>
        <button class="btn btn-sm btn-danger btn-delete" data-index="${index}">Delete</button>
      </td>
    `;
    qnaTableBody.appendChild(row);
  });
}

// Add new Q&A
addNewBtn.addEventListener("click", () => {
  qnaForm.reset();
  document.getElementById("qnaIndex").value = "";
  modalTitle.textContent = "Add Q&A";
});

// Form submit (Add/Edit)
qnaForm.addEventListener("submit", (e) => {
  e.preventDefault();
  const index = document.getElementById("qnaIndex").value;
  const question = document.getElementById("qnaQuestion").value;
  const answer = document.getElementById("qnaAnswer").value;

  if (index === "") {
    // Add
    qnaData.push({ question, answer });
  } else {
    // Edit
    qnaData[index] = { question, answer };
  }

  renderTable();
  qnaModal.hide();
});

// Edit button
qnaTableBody.addEventListener("click", (e) => {
  if (e.target.classList.contains("btn-edit")) {
    const index = e.target.dataset.index;
    const item = qnaData[index];
    document.getElementById("qnaQuestion").value = item.question;
    document.getElementById("qnaAnswer").value = item.answer;
    document.getElementById("qnaIndex").value = index;
    modalTitle.textContent = "Edit Q&A";
    qnaModal.show();
  }

  // Delete button
  if (e.target.classList.contains("btn-delete")) {
    const index = e.target.dataset.index;
    if (confirm("Are you sure you want to delete this Q&A?")) {
      qnaData.splice(index, 1);
      renderTable();
    }
  }
});

// Initial render
renderTable();
