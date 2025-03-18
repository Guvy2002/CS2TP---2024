document.addEventListener('DOMContentLoaded', function () {
    if (!document.getElementById('cart-notification-container')) {
        const container = document.createElement('div');
        container.id = 'cart-notification-container';
        document.body.appendChild(container);
    }
});

function showCartNotification(data) {
    let container = document.getElementById('cart-notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'cart-notification-container';
        document.body.appendChild(container);
    }

    const cartIcon = document.querySelector('.navbar .bi-cart3').parentElement;
    if (cartIcon) {
        cartIcon.classList.add('cart-animation');
        setTimeout(() => {
            cartIcon.classList.remove('cart-animation');
        }, 1000);
    }

    const notification = document.createElement('div');
    notification.className = 'cart-notification';
    notification.innerHTML = `
    <div class="cart-notification-header">
        <span>Added to Cart</span>
        <button class="close-btn"><i class="bi bi-x"></i></button>
    </div>
    <div class="cart-notification-content">
        <img src="${data.productImage}" alt="${data.productName}" class="cart-notification-img">
        <div class="cart-notification-info">
            <div class="cart-notification-title">${data.productName}</div>
            <div class="cart-notification-message">${data.message}</div>
        </div>
    </div>
    <div class="cart-notification-footer">
        <a href="basket.php" class="cart-notification-btn view-cart-btn">View Cart</a>
        <button class="cart-notification-btn continue-shopping-btn">Continue Shopping</button>
    </div>
    <div class="cart-notification-progress"></div>
    `;

    container.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    notification.querySelector('.close-btn').addEventListener('click', () => {
        closeNotification(notification);
    });

    notification.querySelector('.continue-shopping-btn').addEventListener('click', () => {
        closeNotification(notification);
    });

    setTimeout(() => {
        closeNotification(notification);
    }, 5000);
}

function showWishlistNotification(data) {
    let container = document.getElementById('cart-notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'cart-notification-container';
        document.body.appendChild(container);
    }

    const wishlistIcon = document.querySelector('.navbar .bi-heart').parentElement;
    if (wishlistIcon) {
        wishlistIcon.classList.add('cart-animation');
        setTimeout(() => {
            wishlistIcon.classList.remove('cart-animation');
        }, 1000);
    }

    const notification = document.createElement('div');
    notification.className = 'cart-notification';
    notification.innerHTML = `
    <div class="cart-notification-header" style="background-color: #dc3545;">
        <span>Added to Wishlist</span>
        <button class="close-btn"><i class="bi bi-x"></i></button>
    </div>
    <div class="cart-notification-content">
        <img src="${data.productImage}" alt="${data.productName}" class="cart-notification-img">
        <div class="cart-notification-info">
            <div class="cart-notification-title">${data.productName}</div>
            <div class="cart-notification-message">${data.message}</div>
        </div>
    </div>
    <div class="cart-notification-footer">
        <a href="wishlist.php" class="cart-notification-btn view-cart-btn" style="background-color: #dc3545;">View Wishlist</a>
        <button class="cart-notification-btn continue-shopping-btn">Continue Shopping</button>
    </div>
    <div class="cart-notification-progress" style="background-color: #dc3545;"></div>
    `;

    container.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    notification.querySelector('.close-btn').addEventListener('click', () => {
        closeNotification(notification);
    });

    notification.querySelector('.continue-shopping-btn').addEventListener('click', () => {
        closeNotification(notification);
    });

    setTimeout(() => {
        closeNotification(notification);
    }, 5000);
}

function closeNotification(notification) {
    notification.classList.remove('show');
    setTimeout(() => {
        notification.remove();
    }, 300);
}

function showErrorNotification(message) {
    let container = document.getElementById('cart-notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'cart-notification-container';
        document.body.appendChild(container);
    }

    const notification = document.createElement('div');
    notification.className = 'cart-notification';
    notification.style.borderLeft = '4px solid #dc3545';
    notification.innerHTML = `
    <div class="cart-notification-header" style="background-color: #dc3545;">
        <span>Error</span>
        <button class="close-btn"><i class="bi bi-x"></i></button>
    </div>
    <div class="cart-notification-content">
        <i class="bi bi-exclamation-circle" style="font-size: 24px; color: #dc3545; margin-right: 15px;"></i>
        <div class="cart-notification-info">
            <div class="cart-notification-message">${message}</div>
        </div>
    </div>
    <div class="cart-notification-progress" style="background-color: #dc3545;"></div>
    `;

    container.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    notification.querySelector('.close-btn').addEventListener('click', () => {
        closeNotification(notification);
    });

    setTimeout(() => {
        closeNotification(notification);
    }, 5000);
}

async function addToBasket(button) {
    try {
        const gallery = button.closest('.gallery');
        if (!gallery) {
            throw new Error("Gallery container not found");
        }
        const description = gallery.querySelector('div[data-id]');
        if (!description) {
            throw new Error("Product data not found");
        }
        const id = description.getAttribute('data-id');
        if (!id) {
            throw new Error("Product ID not found");
        }
        const Data_Basket = { id: id };
        const resp = await fetch('/addToBasket.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(Data_Basket)
        });
        const data = await resp.json();
        if (data.status === "success") {
            showCartNotification(data);
        } else {
            showErrorNotification(data.message || "Error adding item to basket");
        }
    } catch (error) {
        console.error("Error:", error);
        showErrorNotification("Error adding item to basket: " + error.message);
    }
}

async function addToWishlist(button) {
    try {
        const gallery = button.closest('.gallery');
        if (!gallery) {
            throw new Error("Gallery container not found");
        }
        const description = gallery.querySelector('div[data-id]');
        if (!description) {
            throw new Error("Product data not found");
        }
        const id = description.getAttribute('data-id');
        if (!id) {
            throw new Error("Product ID not found");
        }
        const Data_Wishlist = { id: id };
        const resp = await fetch('/addToWishlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(Data_Wishlist)
        });
        const data = await resp.json();
        if (data.status === "success") {
            showWishlistNotification(data);
        } else {
            showErrorNotification(data.message || "Error adding item to wishlist");
        }
    } catch (error) {
        console.error("Error:", error);
        showErrorNotification("Error adding item to wishlist: " + error.message);
    }
}