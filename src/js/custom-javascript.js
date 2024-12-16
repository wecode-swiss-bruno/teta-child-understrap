// Add your custom JS here.
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const elements = {
        search: {
            toggle: document.querySelector('.search-toggle'),
            form: document.querySelector('.search-form-wrapper'),
            close: document.querySelector('.search-close'),
            input: document.querySelector('.search-field')
        },
        navbar: document.getElementById('main-nav'),
        offcanvas: {
            element: document.querySelector('.offcanvas'),
            toggle: document.querySelector('[data-bs-toggle="offcanvas"]'),
            instance: document.getElementById('navbarOffcanvas'),
            closeBtn: document.getElementById('navbarOffcanvas')?.querySelector('.btn-close')
        }
    };

    const body = document.body;
    let lastScroll = 0;
    const scrollThreshold = 10;

    // Search functionality
    if (elements.search.toggle && elements.search.form && elements.search.close) {
        elements.search.toggle.addEventListener('click', () => {
            elements.search.form.classList.add('active');
            elements.search.input.value = '';
            elements.search.input.focus();
        });

        elements.search.close.addEventListener('click', () => {
            elements.search.form.classList.remove('active');
            elements.search.input.value = '';
        });
    }

    // Navbar scroll functionality with throttling
    function handleScroll() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll <= 0) {
            elements.navbar.classList.remove('scrolled-down', 'scrolled-up');
            return;
        }

        if (Math.abs(currentScroll - lastScroll) < scrollThreshold) return;

        if (currentScroll > lastScroll && currentScroll > 80) {
            if (!elements.navbar.classList.contains('scrolled-down')) {
                elements.navbar.classList.remove('scrolled-up');
                elements.navbar.classList.add('scrolled-down');
            }
        } else if (currentScroll < lastScroll) {
            if (elements.navbar.classList.contains('scrolled-down')) {
                elements.navbar.classList.remove('scrolled-down');
                elements.navbar.classList.add('scrolled-up');
            }
        }

        lastScroll = currentScroll;
    }

    // Throttled scroll listener
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    // Offcanvas functionality
    if (elements.offcanvas.toggle && elements.offcanvas.instance) {
        // Initialize Bootstrap's Offcanvas
        const bsOffcanvas = new bootstrap.Offcanvas(elements.offcanvas.instance, {
            backdrop: false,
            keyboard: true
        });

        // Handle offcanvas events
        elements.offcanvas.instance.addEventListener('show.bs.offcanvas', () => {
            body.classList.add('offcanvas-active');
        });

        elements.offcanvas.instance.addEventListener('hide.bs.offcanvas', () => {
            body.classList.remove('offcanvas-active');
        });

        elements.offcanvas.instance.addEventListener('hidden.bs.offcanvas', () => {
            resetScrolling();
        });

        // Close button handler
        if (elements.offcanvas.closeBtn) {
            elements.offcanvas.closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                bsOffcanvas.hide();
            });
        }

        // Handle navigation links
        const offcanvasLinks = elements.offcanvas.instance.querySelectorAll('.nav-link');
        offcanvasLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                bsOffcanvas.hide();
                const href = link.getAttribute('href');
                if (href) {
                    setTimeout(() => {
                        window.location.href = href;
                    }, 300);
                }
            });
        });

        // Handle toggler click
        elements.offcanvas.toggle.addEventListener('click', () => {
            if (elements.offcanvas.element.classList.contains('show')) {
                setTimeout(resetScrolling, 300);
            }
        });
    }

    // Helper function to reset scrolling
    function resetScrolling() {
        const elements = [document.body, document.documentElement];
        const properties = ['overflow', 'padding-right'];
        
        elements.forEach(element => {
            properties.forEach(property => {
                element.style.removeProperty(property);
            });
        });
        
        body.classList.remove('modal-open');
    }
});