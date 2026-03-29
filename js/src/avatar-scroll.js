import gsap from 'gsap'

const START_SCALE   = 2.5  // grootte bij scroll = 0
const END_SCALE     = 1    // normale grootte
const SCROLL_RANGE  = 150  // px waarover de overgang plaatsvindt

export function initAvatarScroll() {
  const avatar = document.getElementById('site-avatar')
  if (!avatar) return

  // Zet beginschaal direct zodat er geen pop-in is
  gsap.set(avatar, { scale: START_SCALE, transformOrigin: 'left center' })

  function update() {
    const progress = Math.min(window.scrollY / SCROLL_RANGE, 1)
    const scale    = START_SCALE + (END_SCALE - START_SCALE) * progress
    gsap.set(avatar, { scale })
  }

  update()

  window.addEventListener('scroll', update, { passive: true })
}
