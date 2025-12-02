const previewModal = new bootstrap.Modal(document.getElementById("previewModal"));
const previewBody = document.getElementById("previewBody");

// Convert file input to Base64 (client-side only)
function readImage(input, callback) {
  if (!input.files || !input.files[0]) return callback(null);

  const reader = new FileReader();
  reader.onload = () => callback(reader.result);
  reader.readAsDataURL(input.files[0]);
}

// Preview Button
document.getElementById("previewBtn").addEventListener("click", () => {
  previewBody.innerHTML = "Loading...";

  Promise.all([
    new Promise(res => readImage(document.getElementById("sec1Image"), res)),
    new Promise(res => readImage(document.getElementById("sec2Image"), res)),
    new Promise(res => readImage(document.getElementById("sec3Image"), res)),
  ]).then(([img1, img2, img3]) => {

    previewBody.innerHTML = `
      <div class="preview-section">
        <h3>${sec1Title.value}</h3>
        <p>${sec1Text.value}</p>
        ${img1 ? `<img src="${img1}">` : ""}
      </div>

      <div class="preview-section">
        <h3>${sec2Title.value}</h3>
        <p>${sec2Text.value}</p>
        ${img2 ? `<img src="${img2}">` : ""}
      </div>

      <div class="preview-section">
        <h3>${sec3Title.value}</h3>
        <p>${sec3Text.value}</p>
        ${img3 ? `<img src="${img3}">` : ""}
      </div>
    `;
  });

  previewModal.show();
});

// Save Button
document.getElementById("aboutForm").addEventListener("submit", (e) => {
  e.preventDefault();
  alert("Demo only: Changes not saved to database yet.");
});
