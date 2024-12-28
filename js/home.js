document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.favorite-icon').forEach(icon => {
    icon.addEventListener('click', function (e) {
      e.stopPropagation(); // Prevents the click from triggering the parent link
    });
  });
});
