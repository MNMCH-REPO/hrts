document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.closePopup').forEach(function(btn) {
        btn.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    });

    document.querySelectorAll('.popupConfirmClosePopup').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const popupConfirm = this.closest('.popupConfirm');
            const confirmation = popupConfirm.querySelector('.popupConfirmConfirmation');
            confirmation.style.display = 'flex';
        });
    });

    document.querySelectorAll('.popupConfirmCancel').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const confirmation = this.closest('.popupConfirmConfirmation');
            confirmation.style.display = 'none';
        });
    });

    document.querySelectorAll('.popupConfirmOkay').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const popupConfirm = this.closest('.popupConfirm');
            const confirmation = popupConfirm.querySelector('.popupConfirmConfirmation');
            confirmation.style.display = 'none';
            popupConfirm.style.display = 'none';
        });
    });
    document.querySelectorAll('.submit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            this.closest('form').submit();
        });
    });
    if(typeof errorMessage !== 'undefined' && errorMessage){
        document.querySelectorAll('.submit').forEach(function(btn) {
            btn.addEventListener('click', function() {
                this.closest('form').submit();
                // Show a Toastify notification
                Toastify({
                    text: errorMessage,
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                    style: {
                        background: "var(--danger)",
                    },
                    stopOnFocus: true // Stop on focus
                }).showToast();
            });
        });
    }
    if (typeof currentUserName !== 'undefined' && currentUserName) {
        document.querySelectorAll('.accountName').forEach(function(element) {
            element.textContent = currentUserName;
        });   
    }
});
console.log("Current user name set to: " + currentUserName);

const sideNav = document.querySelector(".sideNav");
const navBtns = document.querySelectorAll(".navBtn a");
let shrinkDelay = 1000;
let shrinkTimeout;
function shrinkSideNav() {
    if (window.innerWidth >= 600) { // Check if the viewport width is 600px or more
        sideNav.style.width = "60px";
        navBtns.forEach((btn) => {
            btn.style.display = "none";
        });
    }
}

function expandSideNav() {
    if (window.innerWidth >= 600) { // Check if the viewport width is 600px or more
        clearTimeout(shrinkTimeout);
        sideNav.style.width = "260px";
        navBtns.forEach((btn) => {
            btn.style.display = "flex";
        });
    }
}

// Add event listeners for mouseenter and mouseleave
sideNav.addEventListener("mouseleave", () => {
    if (window.innerWidth >= 600) { // Ensure the condition is checked here as well
        shrinkTimeout = setTimeout(shrinkSideNav, shrinkDelay);
    }
});

sideNav.addEventListener("mouseenter", () => {
    if (window.innerWidth >= 600) { // Ensure the condition is checked here as well
        expandSideNav();
    }
});

// Initial state
if (window.innerWidth >= 600) {
    shrinkSideNav();
}