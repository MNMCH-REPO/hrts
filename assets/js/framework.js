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
    if (typeof userData !== 'undefined' && userData.Name) {
        document.querySelectorAll('.accountName').forEach(function(element) {
            element.textContent = userData.Name;
        });
    }
});

const sideNav = document.querySelector(".sideNav");
const navBtns = document.querySelectorAll(".navBtn a");
let shrinkDelay = 1000;
let shrinkTimeout;
function shrinkSideNav() {
    sideNav.style.width = "60px";
    navBtns.forEach((btn) => {
        btn.style.display = "none";
    });
}
function expandSideNav() {
    clearTimeout(shrinkTimeout);
    sideNav.style.width = "260px";
    navBtns.forEach((btn) => {
        btn.style.display = "flex";
    });
}
sideNav.addEventListener("mouseleave", () => {
    shrinkTimeout = setTimeout(shrinkSideNav, shrinkDelay);
});
sideNav.addEventListener("mouseenter", expandSideNav);
shrinkSideNav();