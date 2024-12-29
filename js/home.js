document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.favorite-icon a').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      const scrollTop = window.scrollY || document.documentElement.scrollTop;
      const url = new URL(link.href);
      url.searchParams.set('scroll', scrollTop);
      window.location.href = url.toString();
    });
  });

  const params = new URLSearchParams(window.location.search);
  const scroll = params.get('scroll');
  if (scroll) {
    window.scrollTo(0, parseInt(scroll, 10));
  }

  // TODO: Fix scroll
});
