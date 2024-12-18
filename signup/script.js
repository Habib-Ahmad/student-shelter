function toggleUploadSections() {
  const studentUploadSections = document.getElementById("studentUploadSections");
  const studentRadio = document.querySelector('input[name="role"][value="student"]');

  // Toggle visibility based on 'student' selection
  if (studentRadio.checked) {
    studentUploadSections.style.display = "block";
  } else {
    studentUploadSections.style.display = "none";
  }
}

// Ensure correct state on page load
document.addEventListener("DOMContentLoaded", () => {
  toggleUploadSections();
});

// Function to update file name on upload
function updateFileName(inputElement) {
  const fileNameSpan = inputElement.nextElementSibling; // Target the adjacent <span> for file name
  if (inputElement.files.length > 0) {
    fileNameSpan.textContent = inputElement.files[0].name; // Update with the uploaded file name
  } else {
    fileNameSpan.textContent = "No file chosen"; // Reset if no file is uploaded
  }
}

// Add event listeners to all file inputs
document.addEventListener("DOMContentLoaded", () => {
  const fileInputs = document.querySelectorAll(".file-upload-input");
  fileInputs.forEach((input) => {
    input.addEventListener("change", () => updateFileName(input));
  });
});
