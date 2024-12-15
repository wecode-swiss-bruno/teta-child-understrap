// Add your custom JS here.

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchToggle = document.querySelector('.search-toggle');
    const searchForm = document.querySelector('.search-form-wrapper');
    const searchClose = document.querySelector('.search-close');
    const searchInput = document.querySelector('.search-field');
    const navbar = document.getElementById('main-nav');
    let lastScroll = 0;
    const scrollThreshold = 10; // Minimum scroll amount to trigger hide/show

    // Search functionality
    if (searchToggle && searchForm && searchClose) {
        searchToggle.addEventListener('click', function() {
            searchForm.classList.add('active');
            searchInput.focus();
        });

        searchClose.addEventListener('click', function() {
            searchForm.classList.remove('active');
        });
    }

    // Navbar scroll functionality
    function handleScroll() {
        const currentScroll = window.pageYOffset;
        
        // Show navbar at the very top
        if (currentScroll <= 0) {
            navbar.classList.remove('scrolled-down');
            navbar.classList.remove('scrolled-up');
            return;
        }

        // Determine scroll direction and distance
        if (Math.abs(currentScroll - lastScroll) < scrollThreshold) {
            return; // Don't do anything if the scroll amount is too small
        }

        // Scrolling down
        if (currentScroll > lastScroll && currentScroll > 80) {
            if (!navbar.classList.contains('scrolled-down')) {
                navbar.classList.remove('scrolled-up');
                navbar.classList.add('scrolled-down');
            }
        } 
        // Scrolling up
        else if (currentScroll < lastScroll) {
            if (navbar.classList.contains('scrolled-down')) {
                navbar.classList.remove('scrolled-down');
                navbar.classList.add('scrolled-up');
            }
        }

        lastScroll = currentScroll;
    }

    // Add scroll event listener with throttling
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    // Offcanvas functionality
    const offcanvasToggle = document.querySelector('[data-bs-toggle="offcanvas"]');
    const offcanvas = document.getElementById('navbarOffcanvas');
    const closeBtn = offcanvas?.querySelector('.btn-close');
    const body = document.body;

    if (offcanvasToggle && offcanvas) {
        // Initialize Bootstrap's Offcanvas
        const bsOffcanvas = new bootstrap.Offcanvas(offcanvas, {
            backdrop: false, // Disable default backdrop
            keyboard: true
        });

        // Show event
        offcanvas.addEventListener('show.bs.offcanvas', function () {
            body.classList.add('offcanvas-active');
        });

        // Hide event
        offcanvas.addEventListener('hide.bs.offcanvas', function () {
            body.classList.remove('offcanvas-active');
        });

        // Close button handler
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                bsOffcanvas.hide();
            });
        }

        // Close offcanvas when clicking on links
        const offcanvasLinks = offcanvas.querySelectorAll('.nav-link');
        offcanvasLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                bsOffcanvas.hide();
                const href = this.getAttribute('href');
                if (href) {
                    setTimeout(() => {
                        window.location.href = href;
                    }, 300);
                }
            });
        });
    }
});