class PostLoader {
    constructor() {
        this.page = 1;
        this.loading = false;
        this.init();
    }

    init() {
        document.addEventListener('click', (e) => {
            const button = e.target.closest('.display-more-button');
            if (button) {
                e.preventDefault();
                this.handleLoadMore(button);
            }
        });
    }

    async handleLoadMore(button) {
        if (this.loading) return;

        this.loading = true;
        button.classList.add('loading');
        
        const section = button.dataset.section;
        const postsHandling = JSON.parse(button.dataset.postsHandling);
        
        try {
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

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new PostLoader();
}); 