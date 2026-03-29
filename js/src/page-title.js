import { animateTitle } from './animate-title'

export function initPageTitle() {
  // Home page is handled by initHero
  if (document.getElementById('hero-title')) return

  const title = document.querySelector('main h1')
  if (!title) return

  // Collect all siblings after the h1 to fade in after the reveal
  const siblings = []
  let next = title.nextElementSibling
  while (next) {
    siblings.push(next)
    next = next.nextElementSibling
  }

  animateTitle(title, siblings)
}
