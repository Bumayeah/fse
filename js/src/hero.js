import gsap from 'gsap'
import { animateTitle } from './animate-title'

export function initHero() {
  const title       = document.getElementById('hero-title')
  const description = document.getElementById('hero-description')
  const socials     = document.getElementById('hero-socials')

  if (!title) return

  const tl = animateTitle(title, [description])

  if (socials && tl) {
    tl.from(
      Array.from(socials.children),
      { y: 12, opacity: 0, duration: 0.5, stagger: 0.07 },
      '-=0.3'
    )
  }
}
