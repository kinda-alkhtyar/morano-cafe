import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
const header = document.querySelector('[data-site-header]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const nav = document.querySelector('[data-primary-nav]');

function syncHeader() {
    header?.classList.toggle('is-scrolled', window.scrollY > 36);
}
syncHeader();
window.addEventListener('scroll', syncHeader, { passive: true });

function closeMenu() {
    header?.classList.remove('is-open');
    document.body.classList.remove('menu-open');
    menuToggle?.setAttribute('aria-expanded', 'false');
    menuToggle?.setAttribute('aria-label', 'Menü öffnen');
}
menuToggle?.addEventListener('click', () => {
    const open = menuToggle.getAttribute('aria-expanded') !== 'true';
    header.classList.toggle('is-open', open);
    document.body.classList.toggle('menu-open', open);
    menuToggle.setAttribute('aria-expanded', String(open));
    menuToggle.setAttribute('aria-label', open ? 'Menü schließen' : 'Menü öffnen');
    if (open) nav?.querySelector('a')?.focus();
});
nav?.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && header?.classList.contains('is-open')) {
        closeMenu();
        menuToggle?.focus();
    }
});
document.addEventListener('click', (event) => {
    if (header?.classList.contains('is-open') && !header.contains(event.target)) closeMenu();
});
window.matchMedia('(min-width: 801px)').addEventListener('change', closeMenu);

const carousel = document.querySelector('[data-carousel]');
if (carousel) {
    const previous = document.querySelector('[data-carousel-prev]');
    const next = document.querySelector('[data-carousel-next]');
    const controls = document.querySelector('.carousel-controls');
    const updateControls = () => {
        controls?.classList.toggle('is-static', carousel.scrollWidth <= carousel.clientWidth + 2);
        previous.disabled = carousel.scrollLeft <= 2;
        next.disabled = carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth - 2;
    };
    const step = () => carousel.firstElementChild?.getBoundingClientRect().width + (parseFloat(getComputedStyle(carousel).columnGap) || 0) || carousel.clientWidth;
    previous?.addEventListener('click', () => carousel.scrollBy({ left: -step(), behavior: 'smooth' }));
    next?.addEventListener('click', () => carousel.scrollBy({ left: step(), behavior: 'smooth' }));
    carousel.addEventListener('scroll', updateControls, { passive: true });
    window.addEventListener('resize', updateControls);
    updateControls();

    let startX = 0;
    let startScroll = 0;
    let dragging = false;
    let moved = false;
    carousel.addEventListener('pointerdown', (event) => {
        if (event.pointerType !== 'mouse' || event.button !== 0) return;
        startX = event.clientX;
        startScroll = carousel.scrollLeft;
        dragging = true;
        moved = false;
    });
    carousel.addEventListener('pointermove', (event) => {
        if (!dragging) return;
        const distance = event.clientX - startX;
        if (Math.abs(distance) > 5) {
            moved = true;
            carousel.classList.add('is-dragging');
            carousel.scrollLeft = startScroll - distance;
        }
    });
    const endDrag = () => { dragging = false; carousel.classList.remove('is-dragging'); };
    window.addEventListener('pointerup', endDrag);
    window.addEventListener('pointercancel', endDrag);
    carousel.addEventListener('click', (event) => {
        if (moved) { event.preventDefault(); moved = false; }
    }, true);
    carousel.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
            event.preventDefault();
            carousel.scrollBy({ left: (event.key === 'ArrowRight' ? 1 : -1) * step(), behavior: 'smooth' });
        }
    });
}

if (!reducedMotion.matches) {
    gsap.registerPlugin(ScrollTrigger);
    const hero = document.querySelector('[data-hero]');
    if (hero) {
        gsap.timeline({ defaults: { ease: 'power3.out' } })
            .fromTo('[data-hero-media] img', { scale: 1.105 }, { scale: 1.025, duration: 2.1, ease: 'power2.out' }, 0)
            .from('[data-hero-line]', { y: 26, opacity: 0, stagger: 0.12, duration: 0.95 }, 0.35);

        const heroImage = hero.querySelector('[data-hero-media] img');
        if (heroImage) {
            const breathing = gsap.to(heroImage, { scale: 1.055, duration: 9, repeat: -1, yoyo: true, ease: 'sine.inOut', delay: 2 });
            ScrollTrigger.create({ trigger: hero, start: 'top bottom', end: 'bottom top', onEnter: () => breathing.resume(), onLeave: () => breathing.pause(), onEnterBack: () => breathing.resume(), onLeaveBack: () => breathing.pause() });
            if (finePointer.matches) {
                const moveX = gsap.quickTo(heroImage, 'x', { duration: 1.2, ease: 'power2.out' });
                const moveY = gsap.quickTo(heroImage, 'y', { duration: 1.2, ease: 'power2.out' });
                hero.addEventListener('pointermove', (event) => {
                    const rect = hero.getBoundingClientRect();
                    moveX(((event.clientX - rect.left) / rect.width - 0.5) * 12);
                    moveY(((event.clientY - rect.top) / rect.height - 0.5) * 8);
                });
                hero.addEventListener('pointerleave', () => { moveX(0); moveY(0); });
            }
        }
    }

    gsap.utils.toArray('[data-reveal]').forEach((element) => {
        gsap.from(element, {
            opacity: 0, y: 42, duration: 0.9, ease: 'power3.out',
            scrollTrigger: { trigger: element, start: 'top 88%', once: true },
        });
    });

    gsap.utils.toArray('.coffee-visual, .story-photo, .visit-photo').forEach((frame) => {
        gsap.fromTo(frame, { clipPath: 'inset(0 0 100% 0)' }, {
            clipPath: 'inset(0 0 0% 0)', duration: 1.25, ease: 'power3.out',
            scrollTrigger: { trigger: frame, start: 'top 88%', once: true },
        });
        const picture = frame.querySelector('img');
        if (picture) gsap.fromTo(picture, { yPercent: -4 }, { yPercent: 4, ease: 'none', scrollTrigger: { trigger: frame, start: 'top bottom', end: 'bottom top', scrub: 1 } });
    });

    if (finePointer.matches) {
        document.querySelectorAll('[data-magnetic]').forEach((link) => {
            const moveX = gsap.quickTo(link, 'x', { duration: 0.45, ease: 'power3.out' });
            const moveY = gsap.quickTo(link, 'y', { duration: 0.45, ease: 'power3.out' });
            link.addEventListener('pointermove', (event) => {
                const rect = link.getBoundingClientRect();
                moveX((event.clientX - rect.left - rect.width / 2) * 0.12);
                moveY((event.clientY - rect.top - rect.height / 2) * 0.16);
            });
            link.addEventListener('pointerleave', () => { moveX(0); moveY(0); });
        });
    }
}
