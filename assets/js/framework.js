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
    document.querySelectorAll('.topNav').forEach(function(topNav) {
        topNav.style.left = document.querySelector('.sideNav').offsetWidth + "px";
        topNav.style.width = "calc(100% - " + document.querySelector('.sideNav').offsetWidth + "px)";
    });
});
