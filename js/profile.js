
function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

function removeQueryParam(param) {
  const url = new URL(window.location.href);
  url.searchParams.delete(param);
  window.history.replaceState({}, document.title, url.toString());
}

document.addEventListener("DOMContentLoaded", () => {
  const message = getQueryParam('message');
  if (message) {
    alert(decodeURIComponent(message.replace(/\+/g, ' ')));

    removeQueryParam('message');
  }
});
