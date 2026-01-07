import './bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';

// Setup Axios defaults
axios.defaults.baseURL = '/api';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';

// Add CSRF token to requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

// Add auth token to requests if exists
const token = localStorage.getItem('auth_token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// Handle 401 Unauthorized globally
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            // Token expired or invalid
            localStorage.removeItem('auth_token');

            // Redirect to login if not already there
            if (window.location.pathname !== '/login') {
                window.location.href = '/login';
            }
        }
        return Promise.reject(error);
    }
);

// Make axios available globally
window.axios = axios;

// Fly to Cart Animation Function
window.animateToCart = function (e, imageUrl) {
    const cart = document.querySelector('#navbar-cart');
    if (!cart) return;

    // Get positions
    const cartRect = cart.getBoundingClientRect();
    const startX = e.clientX;
    const startY = e.clientY;

    // Create fly element
    const flyer = document.createElement('div');
    flyer.className = 'fly-to-cart';
    if (imageUrl) {
        flyer.innerHTML = `<img src="${imageUrl}" alt="product">`;
    } else {
        flyer.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    }

    flyer.style.left = `${startX - 30}px`;
    flyer.style.top = `${startY - 30}px`;

    document.body.appendChild(flyer);

    // Trigger animation after a small delay
    setTimeout(() => {
        flyer.style.left = `${cartRect.left + 5}px`;
        flyer.style.top = `${cartRect.top + 5}px`;
        flyer.style.width = '20px';
        flyer.style.height = '20px';
        flyer.style.opacity = '0.5';
        flyer.style.transform = 'scale(0.5)';
    }, 10);

    // Remove flyer and trigger cart jiggle
    flyer.addEventListener('transitionend', () => {
        flyer.remove();
        // Dispatch event or call Alpine logic to jiggle
        window.dispatchEvent(new CustomEvent('cart-animation-finished'));
    });
};

// Global Toast Notification Function
window.toast = function (message, type = 'info', title = null, duration = 3000) {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: {
            type: type,
            title: title,
            message: message,
            duration: duration
        }
    }));
};

// Convenience methods
window.toast.success = (message, title = 'Success!', duration = 3000) => window.toast(message, 'success', title, duration);
window.toast.error = (message, title = 'Error!', duration = 3000) => window.toast(message, 'error', title, duration);
window.toast.warning = (message, title = 'Warning!', duration = 3000) => window.toast(message, 'warning', title, duration);
window.toast.info = (message, title = 'Info', duration = 3000) => window.toast(message, 'info', title, duration);

// Global Confirm Dialog Function
window.confirmDialog = async function (message, title = 'Confirm Action', confirmText = 'OK') {
    return new Promise((resolve) => {
        // Create a unique event listener for this confirmation
        const responseHandler = (e) => {
            window.removeEventListener('confirm-response', responseHandler);
            resolve(e.detail.confirmed);
        };

        window.addEventListener('confirm-response', responseHandler);

        // Dispatch the confirm request
        window.dispatchEvent(new CustomEvent('confirm', {
            detail: { message, title, confirmText }
        }));
    });
};

// Start Alpine
window.Alpine = Alpine;
Alpine.start();