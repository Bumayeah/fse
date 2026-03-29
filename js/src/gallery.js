import gsap from 'gsap'

export function initGallery() {
  const gallery = document.getElementById('photo-gallery')
  if (!gallery) return

  const cards = gallery.querySelectorAll('[data-gallery-card]')
  const imgs  = gallery.querySelectorAll('[data-parallax]')

  if (!cards.length) return

  // --- Entrance: staggered slide-in when gallery scrolls into view ---
  gsap.set(cards, { opacity: 0, y: 72 })

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return
        gsap.to(cards, {
          opacity: 1,
          y: 0,
          duration: 0.8,
          ease: 'power3.out',
          stagger: 0.12,
        })
        observer.disconnect()
      })
    },
    { threshold: 0.2 }
  )

  observer.observe(gallery)

  // --- Scroll parallax: each image drifts at its own speed within the card ---
  // Max shift = 17.5% of card height (matches -top-[17.5%] buffer)
  function updateParallax() {
    const rect          = gallery.getBoundingClientRect()
    const galleryCenter = rect.top + rect.height / 2
    const offset        = galleryCenter - window.innerHeight / 2

    imgs.forEach((img) => {
      const factor   = parseFloat(img.dataset.parallax) || 0
      const card     = img.closest('[data-gallery-card]')
      const maxShift = card ? card.offsetHeight * 0.25 : 60
      const y        = Math.max(-maxShift, Math.min(maxShift, offset * factor))
      gsap.set(img, { y })
    })
  }

  updateParallax()
  window.addEventListener('scroll', updateParallax, { passive: true })
}
