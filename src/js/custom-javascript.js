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

    // Post Loader Class
    class PostLoader {
        constructor() {
            this.page = 1;
            this.loading = false;
            this.init();
        }

        init() {
            document.addEventListener('click', (e) => {
                const button = e.target.closest('.display-more-button:not(.related-posts-section .display-more-button)');
                if (button) {
                    e.preventDefault();
                    this.handleLoadMore(button);
                }
            });
        }

        async handleLoadMore(button) {
            if (this.loading) {
                console.log('Already loading...');
                return;
            }

            console.log('Starting load more...', {
                section: button.dataset.section,
                postsHandling: button.dataset.postsHandling
            });

            this.loading = true;
            button.classList.add('loading');
            
            const section = button.dataset.section;
            const postsHandling = JSON.parse(button.dataset.postsHandling);
            
            try {
                console.log('Sending AJAX request...', {
                    action: 'load_more_posts',
                    nonce: tetazAjax.nonce,
                    page: this.page + 1,
                    section: section,
                    posts_handling: postsHandling
                });

                const response = await fetch(tetazAjax.ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'load_more_posts',
                        nonce: tetazAjax.nonce,
                        page: ++this.page,
                        section: section,
                        posts_handling: JSON.stringify(postsHandling)
                    })
                });

                const data = await response.json();
                console.log('Response received:', data);
                
                if (data.success) {
                    this.handleSuccess(button, data);
                } else {
                    console.error('Error loading posts:', data.message);
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                this.loading = false;
                button.classList.remove('loading');
            }
        }

        handleSuccess(button, data) {
            const wrapper = button.closest('.fullscreen-posts-wrapper, .grid-split-posts-wrapper');
            
            if (wrapper) {
                // Insert new posts before the display-more-wrapper
                const displayMoreWrapper = wrapper.querySelector('.display-more-wrapper');
                displayMoreWrapper.insertAdjacentHTML('beforebegin', data.data.html);

                // Hide button if no more posts
                if (data.data.has_more === false) {
                    displayMoreWrapper.style.display = 'none';
                }
            }
        }
    }

    // Related Posts Loader Class
    class RelatedPostsLoader {
        constructor() {
            this.page = 1;
            this.loading = false;
            this.init();
        }

        init() {
            document.addEventListener('click', (e) => {
                const button = e.target.closest('.related-posts-section .load-more-button');
                if (button) {
                    e.preventDefault();
                    this.handleLoadMore(button);
                }
            });
        }

        async handleLoadMore(button) {
            if (this.loading) {
                console.log('Already loading related posts...');
                return;
            }

            console.log('Starting to load more posts, page:', this.page + 1);

            this.loading = true;
            button.classList.add('loading');
            
            const currentPostId = button.dataset.currentPostId;
            
            try {
                const response = await fetch(tetazAjax.ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'load_more_related_posts',
                        nonce: tetazAjax.nonce,
                        page: ++this.page,
                        current_post_id: currentPostId
                    })
                });

                const data = await response.json();
                console.log('Response received:', data);
                
                if (data.success) {
                    this.handleSuccess(button, data);
                } else {
                    console.error('Error loading related posts:', data.message);
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                this.loading = false;
                button.classList.remove('loading');
            }
        }

        handleSuccess(button, data) {
            const row = button.closest('.related-posts-section').querySelector('.related-posts-row');
            
            if (row) {
                row.insertAdjacentHTML('beforeend', data.data.html);

                // Hide button if no more posts
                if (data.data.has_more === false) {
                    button.closest('.load-more-wrapper').style.display = 'none';
                }
            }
        }
    }

    // Initialize loaders only once
    if (!window.postLoader) {
        window.postLoader = new PostLoader();
    }
    if (!window.relatedPostsLoader) {
        window.relatedPostsLoader = new RelatedPostsLoader();
    }
});