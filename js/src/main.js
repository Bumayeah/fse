import { initHeaderScroll } from './header-scroll'
import { initAvatarScroll } from './avatar-scroll'
import { initHero } from './hero'
import { initPageTitle } from './page-title'
import { initGallery } from './gallery'
import { initMobileNav } from './mobile-nav'
import { initThemeSwitcher } from './theme-switcher'

document.addEventListener('DOMContentLoaded', function () {
  initHeaderScroll()
  initAvatarScroll()
  initHero()
  initPageTitle()
  initGallery()
  initMobileNav()
  initThemeSwitcher()
})
