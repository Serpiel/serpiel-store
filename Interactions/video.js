const video = document.getElementById('myVideo');
const source = document.getElementById('videoSource');

function updateVideoSource() {
    const isMobile = window.innerWidth <= 768;

    source.src = isMobile ? "/Assets/serpiel_logo_mobile.mp4" : "/Assets/serpiel_logo.mp4";
    video.load(); // recharge la bonne vidéo
}

updateVideoSource(); // au chargement

window.addEventListener('resize', () => {
    updateVideoSource(); // au redimensionnement
});
