import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
const header = document.querySelector('[data-site-header]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const nav = document.querySelector('[data-primary-nav]');
const isPersian = document.body.dataset.locale === 'fa';

function syncHeader() {
    header?.classList.toggle('is-scrolled', window.scrollY > 36);
}
syncHeader();
window.addEventListener('scroll', syncHeader, { passive: true });

function closeMenu() {
    header?.classList.remove('is-open');
    document.body.classList.remove('menu-open');
    menuToggle?.setAttribute('aria-expanded', 'false');
    menuToggle?.setAttribute('aria-label', isPersian ? 'باز کردن منو' : 'Menü öffnen');
}
menuToggle?.addEventListener('click', () => {
    const open = menuToggle.getAttribute('aria-expanded') !== 'true';
    header.classList.toggle('is-open', open);
    document.body.classList.toggle('menu-open', open);
    menuToggle.setAttribute('aria-expanded', String(open));
    menuToggle.setAttribute('aria-label', isPersian ? (open ? 'بستن منو' : 'باز کردن منو') : (open ? 'Menü schließen' : 'Menü öffnen'));
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
    const rtl = getComputedStyle(carousel).direction === 'rtl';
    const previous = document.querySelector('[data-carousel-prev]');
    const next = document.querySelector('[data-carousel-next]');
    const controls = document.querySelector('.carousel-controls');
    const updateControls = () => {
        controls?.classList.toggle('is-static', carousel.scrollWidth <= carousel.clientWidth + 2);
        previous.disabled = rtl ? carousel.scrollLeft >= -2 : carousel.scrollLeft <= 2;
        next.disabled = rtl ? carousel.scrollLeft - carousel.clientWidth <= -carousel.scrollWidth + 2 : carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth - 2;
    };
    const step = () => carousel.firstElementChild?.getBoundingClientRect().width + (parseFloat(getComputedStyle(carousel).columnGap) || 0) || carousel.clientWidth;
    previous?.addEventListener('click', () => carousel.scrollBy({ left: (rtl ? 1 : -1) * step(), behavior: 'smooth' }));
    next?.addEventListener('click', () => carousel.scrollBy({ left: (rtl ? -1 : 1) * step(), behavior: 'smooth' }));
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

document.querySelectorAll('[data-map-load]').forEach(button => button.addEventListener('click', () => {
    const panel = button.closest('[data-map-consent]');
    if (!panel) return;
    const iframe = document.createElement('iframe');
    iframe.title = button.dataset.mapTitle || 'Interaktive Karte';
    iframe.src = button.dataset.mapSrc;
    iframe.loading = 'lazy';
    iframe.referrerPolicy = 'no-referrer-when-downgrade';
    iframe.allowFullscreen = true;
    panel.replaceWith(iframe);
}));

const menuPage = document.querySelector('[data-menu-page]');
if (menuPage) {
    const filters = [...menuPage.querySelectorAll('[data-filter]')];
    const subfilters = [...menuPage.querySelectorAll('[data-filter-sub]')];
    const sections = [...menuPage.querySelectorAll('[data-category]')];
    const search = menuPage.querySelector('[data-menu-search]');
    const count = menuPage.querySelector('[data-menu-count]');
    const empty = menuPage.querySelector('[data-menu-empty]');
    const available = new Set(sections.map(section => section.dataset.category));
    const selectedFromUrl = () => {
        const params = new URLSearchParams(location.search);
        const query = params.get('kategorie');
        const hash = location.hash.replace('#kategorie-', '');
        return available.has(query) ? query : available.has(hash) ? hash : 'all';
    };
    let selected = selectedFromUrl();
    let selectedSub = new URLSearchParams(location.search).get('gruppe') || 'all';
    const render = () => {
        const term = search.value.trim().toLocaleLowerCase('de-AT');
        let visible = 0;
        sections.forEach(section => {
            let sectionCount = 0;
            section.querySelectorAll('[data-menu-group]').forEach(group => {
                let groupCount = 0;
                group.querySelectorAll('[data-menu-product]').forEach(product => {
                    const match = (!term || product.dataset.search.includes(term)) && (selected === 'all' || section.dataset.category === selected) && (selectedSub === 'all' || group.dataset.menuGroup === selectedSub);
                    product.hidden = !match;
                    if (match) { groupCount++; sectionCount++; visible++; }
                });
                group.hidden = groupCount === 0;
            });
            section.hidden = sectionCount === 0;
        });
        filters.forEach(filter => filter.setAttribute('aria-current', String(filter.dataset.filter === selected)));
        subfilters.forEach(filter => filter.setAttribute('aria-current', String(filter.dataset.filterSub === selectedSub)));
        menuPage.querySelector('[data-menu-subfilters]').hidden = !['kaffee', 'drinks'].includes(selected) && selectedSub === 'all';
        count.textContent = isPersian ? `${visible.toLocaleString('fa-IR')} محصول` : `${visible} ${visible === 1 ? 'Produkt' : 'Produkte'}`;
        empty.hidden = visible !== 0;
    };
    filters.forEach(filter => filter.addEventListener('click', event => {
        event.preventDefault();
        selected = filter.dataset.filter;
        selectedSub = 'all';
        const url = selected === 'all' ? location.pathname : `${location.pathname}?kategorie=${encodeURIComponent(selected)}`;
        history.replaceState(null, '', url);
        render();
    }));
    subfilters.forEach(filter => filter.addEventListener('click', event => {
        event.preventDefault();
        selectedSub = filter.dataset.filterSub;
        selected = selectedSub === 'punsch' ? 'all' : ['kaffee', 'iced-coffee', 'milkshakes'].includes(selectedSub) ? 'kaffee' : 'drinks';
        history.replaceState(null, '', `${location.pathname}?kategorie=${selected}&gruppe=${encodeURIComponent(selectedSub)}`);
        render();
    }));
    search.addEventListener('input', render);
    window.addEventListener('popstate', () => { selected = selectedFromUrl(); selectedSub = new URLSearchParams(location.search).get('gruppe') || 'all'; render(); });
    render();
    menuPage.querySelectorAll('[data-product-open]').forEach(button => button.addEventListener('click', () => {
        const dialog = menuPage.querySelector(`[data-product-dialog="${button.dataset.productOpen}"]`);
        dialog?.showModal();
    }));
    menuPage.querySelectorAll('[data-product-dialog]').forEach(dialog => {
        dialog.querySelector('[data-product-close]')?.addEventListener('click', () => dialog.close());
        dialog.addEventListener('click', event => { if (event.target === dialog) dialog.close(); });
    });
}
