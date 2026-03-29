import gsap from 'gsap'

/**
 * Word-reveal animation for a title element,
 * followed by optional extra elements that fade + drift up.
 */
export function animateTitle(title, extraEls = []) {
  if (!title) return

  const words = title.textContent.trim().split(/\s+/)
  title.innerHTML = words
    .map(
      (word) =>
        `<span style="display:inline-block;overflow:hidden;vertical-align:bottom">` +
        `<span class="anim-word" style="display:inline-block">${word}</span></span>`
    )
    .join(' ')

  const wordEls = title.querySelectorAll('.anim-word')
  const tl = gsap.timeline({ delay: 0.1, defaults: { ease: 'power3.out' } })

  tl.from(wordEls, { y: '115%', duration: 0.75, stagger: 0.07 })

  extraEls.forEach((el, i) => {
    if (!el) return
    tl.from(el, { y: 20, opacity: 0, duration: 0.6 }, i === 0 ? '-=0.35' : '-=0.3')
  })

  return tl
}
