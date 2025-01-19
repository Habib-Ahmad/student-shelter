document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.favorite-icon a').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
    });
  });

  const url = new URL(window.location.href);
  const scroll = url.searchParams.get('city');
  if (scroll) {
    const searchFiltersElement = document.getElementById('search-filters');
    if (searchFiltersElement) {
      searchFiltersElement.scrollIntoView({ behavior: 'smooth' });
    }
  }
});
