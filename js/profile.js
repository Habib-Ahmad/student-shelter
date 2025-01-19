
function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

function removeQueryParam(param) {
  const url = new URL(window.location.href);
  url.searchParams.delete(param);
  window.history.replaceState({}, document.title, url.toString());
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
  const fileInputs = document.querySelectorAll(".file-upload-input");
  fileInputs.forEach((input) => {
    input.addEventListener("change", () => updateFileName(input));
  });

  const message = getQueryParam('message');
  if (message) {
    alert(decodeURIComponent(message.replace(/\+/g, ' ')));

    removeQueryParam('message');
  }
});
