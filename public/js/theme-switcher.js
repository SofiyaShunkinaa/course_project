document.addEventListener('DOMContentLoaded', function() {
    const themeButton = document.querySelector('.btn-group');
  
    themeButton.addEventListener('click', function(e) {
      const selectedTheme = e.target.textContent;
      if (selectedTheme === 'Dark') {
        localStorage.setItem('theme', 'dark');
        document.body.classList.add('dark-theme');
        document.body.classList.remove('light-theme');
      } else if (selectedTheme === 'Light') {
        localStorage.setItem('theme', 'light');
        document.body.classList.add('light-theme');
        document.body.classList.remove('dark-theme');
      }
    });

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
      } else if (savedTheme === 'light') {
        document.body.classList.add('light-theme');
      }
    }
  });