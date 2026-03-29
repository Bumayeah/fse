import gsap from 'gsap'

export function initHeaderScroll() {
  const header   = document.getElementById('site-header')
  const menuBtn  = document.getElementById('fse-scroll-menu-btn')
  const switcher = document.getElementById('fse-theme-switcher')

  if (!header) return

  let prevScrollY = 0
  let isHidden    = false

  function positionMenuBtn() {
    if (!menuBtn || !switcher) return
    // Temporarily restore header transform so getBoundingClientRect is accurate
    if (isHidden) gsap.set(header, { y: 0, opacity: 1 })
    const rect = switcher.getBoundingClientRect()
    menuBtn.style.top    = rect.top  + 'px'
    menuBtn.style.left   = rect.left + 'px'
    menuBtn.style.width  = rect.width  + 'px'
    menuBtn.style.height = rect.height + 'px'
    if (isHidden) gsap.set(header, { y: -110, opacity: 0 })
  }

  positionMenuBtn()

  let resizeTimer
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer)
    resizeTimer = setTimeout(positionMenuBtn, 100)
  })

  function showHeader() {
    gsap.to(header, {
      y: 0,
      opacity: 1,
      duration: 0.45,
      ease: 'power3.out',
    })
    if (menuBtn) {
      gsap.to(menuBtn, {
        opacity: 0,
        duration: 0.2,
        ease: 'power2.in',
        onComplete: () => { menuBtn.style.pointerEvents = 'none' },
      })
    }
    isHidden = false
  }

  function hideHeader() {
    gsap.to(header, {
      y: -110,
      opacity: 0,
      duration: 0.35,
      ease: 'power2.in',
    })
    if (menuBtn) {
      gsap.to(menuBtn, {
        opacity: 1,
        duration: 0.3,
        ease: 'power2.out',
        onStart: () => { menuBtn.style.pointerEvents = 'auto' },
      })
    }
    isHidden = true
  }

  if (menuBtn) {
    menuBtn.addEventListener('click', showHeader)
  }

  window.addEventListener('scroll', function () {
    const y     = window.scrollY
    const delta = y - prevScrollY

    if (y < 80) {
      if (isHidden) showHeader()
      prevScrollY = y
      return
    }

    if (delta > 4 && !isHidden) {
      hideHeader()
    } else if (delta < -4 && isHidden) {
      showHeader()
    }

    prevScrollY = y
  }, { passive: true })
}
