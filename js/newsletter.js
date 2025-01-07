class NewsletterForm {
    constructor() {
        this.form = document.getElementById('newsletter-form');
        this.messageContainer = this.form.querySelector('.newsletter-message');
        this.submitButton = this.form.querySelector('.btn-newsletter');
        this.init();
    }

    init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    async handleSubmit(e) {
        e.preventDefault();

        // Disable submit button and show loading state
        this.submitButton.disabled = true;
        this.submitButton.classList.add('loading');

        const formData = new FormData(this.form);
        formData.append('action', 'tetaz_newsletter_submit');
        formData.append('nonce', document.getElementById('newsletter_nonce').value);

        try {
            const response = await fetch(tetazAjax.ajaxurl, {
                method: 'POST',
                body: new URLSearchParams(formData)
            });

            const data = await response.json();
            
            this.messageContainer.style.display = 'block';
            
            if (data.success) {
                this.messageContainer.textContent = data.data;
                this.messageContainer.classList.remove('error');
                this.messageContainer.classList.add('success');
                this.form.reset();
            } else {
                this.messageContainer.textContent = data.data;
                this.messageContainer.classList.remove('success');
                this.messageContainer.classList.add('error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.messageContainer.style.display = 'block';
            this.messageContainer.textContent = 'Une erreur est survenue. Veuillez réessayer.';
            this.messageContainer.classList.remove('success');
            this.messageContainer.classList.add('error');
        } finally {
            // Re-enable submit button and remove loading state
            this.submitButton.disabled = false;
            this.submitButton.classList.remove('loading');
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new NewsletterForm();
}); 