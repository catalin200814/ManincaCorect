document.addEventListener('DOMContentLoaded', function () {

  const navLinks = document.querySelectorAll('.nav-links a');
  navLinks.forEach(link => {
    if (link.getAttribute('href') === window.location.pathname.split('/').pop()) {
      link.style.color = '#6FA043';
      link.style.fontWeight = '600';
    }
  });

  const mealCells = document.querySelectorAll('.meal-cell.empty-slot');
  mealCells.forEach(cell => {
    cell.addEventListener('click', function () {
      this.style.background = '#EAF3E2';
      this.style.borderStyle = 'solid';
      this.style.borderColor = '#6FA043';
      this.innerHTML = '✅';
    });
  });

  const featureCards = document.querySelectorAll('.feature-card');
  featureCards.forEach(card => {
    card.addEventListener('mouseenter', function () {
      this.style.borderTop = '4px solid #6FA043';
    });
    card.addEventListener('mouseleave', function () {
      this.style.borderTop = 'none';
    });
  });

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.feature-card, .stat-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity .5s ease, transform .5s ease';
    observer.observe(el);
  });

});