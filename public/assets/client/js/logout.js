window.addEventListener('beforeunload', () => {
    navigator.sendBeacon('http://localhost/WebThiTN-Oto/client/auth/logout.php');
});