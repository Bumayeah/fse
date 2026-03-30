export function initThemeSwitcher() {
  var btn = document.getElementById('fse-theme-switcher')
  if (!btn) return

  function isDark() {
    return document.documentElement.classList.contains('dark')
  }

  function setTheme(dark) {
    if (dark) {
      document.documentElement.classList.add('dark')
      localStorage.setItem('fse_theme', 'dark')
      btn.setAttribute('aria-label', 'Switch to light theme')
    } else {
      document.documentElement.classList.remove('dark')
      localStorage.setItem('fse_theme', 'light')
      btn.setAttribute('aria-label', 'Switch to dark theme')
    }
  }

  // Sync aria-label with current state (class already set by inline head script)
  btn.setAttribute('aria-label', isDark() ? 'Switch to light theme' : 'Switch to dark theme')

  btn.addEventListener('click', function () {
    setTheme(!isDark())
  })
}
