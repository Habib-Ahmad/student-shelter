function toggleUploadSections() {
  const studentUploadSections = document.getElementById("studentUploadSections");
  const studentRadio = document.querySelector('input[name="role"][value="student"]');

  if (studentRadio.checked) {
    studentUploadSections.style.display = "block";
  } else {
    studentUploadSections.style.display = "none";
  }
}

function updateFileName(inputElement) {
  const fileNameSpan = inputElement.nextElementSibling;
  if (inputElement.files.length > 0) {
    fileNameSpan.textContent = inputElement.files[0].name;
  } else {
    fileNameSpan.textContent = "No file chosen";
  }
}

document.addEventListener("DOMContentLoaded", () => {
  toggleUploadSections();

  const fileInputs = document.querySelectorAll(".file-upload-input");
  fileInputs.forEach((input) => {
    input.addEventListener("change", () => updateFileName(input));
  });
});
