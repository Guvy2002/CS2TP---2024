<?php 
if (isset($_POST['footerSubmit'])){
	$email = $_POST['email'];
	header("Location: sendEmail.php?contents=newsletter&email=" . urlencode($email) . "&redirect=" . urlencode("/homepage.php"));	
	exit();
}
?>

<footer class="footer-container">
    <div class="newsletter-section">
        <p>Sign up for the latest Tech news and offers!</p>
        <form class="signup-form" method="POST">
            <div class="form-group">
                <label for="email">EMAIL ADDRESS*</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email Address" required>
            </div>
            <button type="submit" name="footerSubmit" class="signup-button">SIGN UP</button>
        </form>

        <p class="disclaimer"> *By signing up, you understand and agree that your data will be collected and used
            subject to our Privacy Policy and Terms of Use.</p>

        <div class="social-icons">
            <a href="https://www.instagram.com/" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="https://www.facebook.com/" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://x.com/" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="https://youtube.com/" aria-label="Youtube"><i class="bi bi-youtube"></i></a>
            <a href="https://uk.pinterest.com/" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
        </div>
    </div>
    <div class="footer-links">
        <div class="footer-column">
            <h3>COMPANY</h3>
            <ul>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="experts.php">Experts and Spokemodels</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>CUSTOMER SERVICE</h3>
            <ul>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="myaccount.php">My Account</a></li>
            </ul>
        </div>
    </div>

    <div class="back-to-top-container">
        <a href="#top" class="back-to-top-button">BACK TO TOP ↑</a>
    </div>
</footer>
<div id="cookie-disclaimer" class="cookie-disclaimer">
    <div class="cookie-disclaimer-content">
        <div class="cookie-text">
            <h3>Cookie Notice</h3>
            <p>We use cookies to enhance your experience on our website. By continuing to browse our site, you consent
                to our use of cookies in accordance with our Cookie Policy.</p>
        </div>
        <div class="cookie-buttons">
            <button id="accept-cookies" class="cookie-button accept">Accept All</button>
            <button id="customize-cookies" class="cookie-button customize">Customize</button>
            <button id="decline-cookies" class="cookie-button decline">Decline All</button>
        </div>
    </div>
</div>


<div id="cookie-modal" class="cookie-modal">
    <div class="cookie-modal-content">
        <div class="cookie-modal-header">
            <h3>Cookie Preferences</h3>
            <button id="close-modal" class="close-modal">&times;</button>
        </div>
        <div class="cookie-modal-body">
            <div class="cookie-option">
                <div class="cookie-option-header">
                    <label class="cookie-switch">
                        <input type="checkbox" id="necessary-cookies" checked disabled>
                        <span class="cookie-slider"></span>
                    </label>
                    <h4>Necessary Cookies</h4>
                </div>
                <p>These cookies are required for basic website functionality and cannot be disabled.</p>
            </div>
            <div class="cookie-option">
                <div class="cookie-option-header">
                    <label class="cookie-switch">
                        <input type="checkbox" id="preference-cookies" checked>
                        <span class="cookie-slider"></span>
                    </label>
                    <h4>Preference Cookies</h4>
                </div>
                <p>These cookies allow us to remember your preferences and customize your experience.</p>
            </div>
            <div class="cookie-option">
                <div class="cookie-option-header">
                    <label class="cookie-switch">
                        <input type="checkbox" id="analytics-cookies" checked>
                        <span class="cookie-slider"></span>
                    </label>
                    <h4>Analytics Cookies</h4>
                </div>
                <p>These cookies help us understand how visitors interact with our website.</p>
            </div>
            <div class="cookie-option">
                <div class="cookie-option-header">
                    <label class="cookie-switch">
                        <input type="checkbox" id="marketing-cookies" checked>
                        <span class="cookie-slider"></span>
                    </label>
                    <h4>Marketing Cookies</h4>
                </div>
                <p>These cookies are used to display relevant advertisements and marketing campaigns.</p>
            </div>
        </div>
        <div class="cookie-modal-footer">
            <button id="save-preferences" class="cookie-button save">Save Preferences</button>
        </div>
    </div>
</div>
</body>

<style>
    .cookie-disclaimer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        color: white;
        z-index: 10000;
        padding: 15px 20px;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
        display: none;
    }

    .cookie-disclaimer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .cookie-text {
        flex: 1;
        min-width: 300px;
        padding-right: 20px;
    }

    .cookie-text h3 {
        margin-top: 0;
        margin-bottom: 10px;
        color: white;
        font-size: 18px;
    }

    .cookie-text p {
        margin: 0;
        font-size: 14px;
        line-height: 1.5;
    }

    .cookie-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .cookie-button {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .cookie-button.accept {
        background-color: #0078d7;
        color: white;
    }

    .cookie-button.accept:hover {
        background-color: #005bb5;
    }

    .cookie-button.customize {
        background-color: #555;
        color: white;
    }

    .cookie-button.customize:hover {
        background-color: #444;
    }

    .cookie-button.decline {
        background-color: transparent;
        color: white;
        border: 1px solid white;
    }

    .cookie-button.decline:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .cookie-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 10001;
        justify-content: center;
        align-items: center;
    }

    .cookie-modal-content {
        background-color: white;
        width: 90%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    .cookie-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .cookie-modal-header h3 {
        margin: 0;
        color: #333;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }

    .cookie-modal-body {
        padding: 20px;
    }

    .cookie-option {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .cookie-option:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .cookie-option-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .cookie-option-header h4 {
        margin: 0 0 0 15px;
        color: #333;
    }

    .cookie-option p {
        margin: 0 0 0 50px;
        color: #666;
        font-size: 14px;
    }

    .cookie-modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        text-align: right;
    }

    .cookie-button.save {
        background-color: #0078d7;
        color: white;
    }

    .cookie-button.save:hover {
        background-color: #005bb5;
    }

    .cookie-switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 24px;
    }

    .cookie-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .cookie-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .cookie-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.cookie-slider {
        background-color: #0078d7;
    }

    input:checked+.cookie-slider:before {
        transform: translateX(16px);
    }

    input:disabled+.cookie-slider {
        background-color: #0078d7;
        opacity: 0.6;
        cursor: not-allowed;
    }

    [data-theme="dark"] .cookie-modal-content {
        background-color: #2d2d2d;
    }

    [data-theme="dark"] .cookie-modal-header {
        border-bottom-color: #444;
    }

    [data-theme="dark"] .cookie-modal-header h3,
    [data-theme="dark"] .cookie-option-header h4 {
        color: #f0f0f0;
    }

    [data-theme="dark"] .close-modal {
        color: #aaa;
    }

    [data-theme="dark"] .cookie-option {
        border-bottom-color: #444;
    }

    [data-theme="dark"] .cookie-option p {
        color: #aaa;
    }

    [data-theme="dark"] .cookie-modal-footer {
        border-top-color: #444;
    }

    [data-theme="dark"] .cookie-slider {
        background-color: #555;
    }

    [data-theme="dark"] input:disabled+.cookie-slider {
        opacity: 0.7;
    }

    @media (max-width: 768px) {
        .cookie-disclaimer-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .cookie-text {
            margin-bottom: 15px;
            padding-right: 0;
        }

        .cookie-buttons {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cookieDisclaimer = document.getElementById('cookie-disclaimer');
        const cookieModal = document.getElementById('cookie-modal');

        const acceptCookiesBtn = document.getElementById('accept-cookies');
        const customizeCookiesBtn = document.getElementById('customize-cookies');
        const declineCookiesBtn = document.getElementById('decline-cookies');

        const closeModalBtn = document.getElementById('close-modal');
        const savePreferencesBtn = document.getElementById('save-preferences');

        const preferenceCookieCheckbox = document.getElementById('preference-cookies');
        const analyticsCookieCheckbox = document.getElementById('analytics-cookies');
        const marketingCookieCheckbox = document.getElementById('marketing-cookies');

        function setCookie(name, value, days) {
            let expires = '';
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + value + expires + '; path=/';
        }

        function getCookie(name) {
            const nameEQ = name + '=';
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function checkCookieConsent() {
            const cookieConsent = getCookie('cookie_consent');

            if (!cookieConsent) {
                cookieDisclaimer.style.display = 'block';
            } else {
               
                try {
                    const preferences = JSON.parse(cookieConsent);
                    updateCookiePreferences(preferences);
                } catch (e) {
                    console.error('Error parsing cookie preferences', e);
                }
            }
        }
  
        function updateCookiePreferences(preferences) {
            if (preferences) {
                preferenceCookieCheckbox.checked = preferences.preference;
                analyticsCookieCheckbox.checked = preferences.analytics;
                marketingCookieCheckbox.checked = preferences.marketing;
            }
        }

        function saveCurrentPreferences() {
            const preferences = {
                necessary: true, 
                preference: preferenceCookieCheckbox.checked,
                analytics: analyticsCookieCheckbox.checked,
                marketing: marketingCookieCheckbox.checked
            };

            setCookie('cookie_consent', JSON.stringify(preferences), 365); 
            return preferences;
        }

        acceptCookiesBtn.addEventListener('click', function () {
            preferenceCookieCheckbox.checked = true;
            analyticsCookieCheckbox.checked = true;
            marketingCookieCheckbox.checked = true;

            saveCurrentPreferences();
            cookieDisclaimer.style.display = 'none';
        });

        declineCookiesBtn.addEventListener('click', function () {
            preferenceCookieCheckbox.checked = false;
            analyticsCookieCheckbox.checked = false;
            marketingCookieCheckbox.checked = false;

            saveCurrentPreferences();
            cookieDisclaimer.style.display = 'none';
        });

        customizeCookiesBtn.addEventListener('click', function () {
            cookieModal.style.display = 'flex';
        });

        closeModalBtn.addEventListener('click', function () {
            cookieModal.style.display = 'none';
        });

        savePreferencesBtn.addEventListener('click', function () {
            saveCurrentPreferences();
            cookieModal.style.display = 'none';
            cookieDisclaimer.style.display = 'none';
        });

        window.addEventListener('click', function (event) {
            if (event.target === cookieModal) {
                cookieModal.style.display = 'none';
            }
        });

        checkCookieConsent();
    });
</script>

</html>