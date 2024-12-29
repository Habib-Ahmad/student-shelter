document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.favorite-icon a').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
    });
  });
});