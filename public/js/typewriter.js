document.addEventListener('DOMContentLoaded', function() {
    var text = 'Kehadiran Mahasiswa';
    var el = document.getElementById('typewriter-text');
    var charIndex = 0;
    var isDeleting = false;
    var delay = 80;

    function typeLoop() {
        if (!isDeleting) {
            el.textContent += text.charAt(charIndex);
            charIndex++;
            if (charIndex === text.length) {
                isDeleting = true;
                setTimeout(typeLoop, 1500);
                return;
            }
        } else {
            el.textContent = text.substring(0, charIndex - 1);
            charIndex--;
            if (charIndex === 0) {
                isDeleting = false;
                setTimeout(typeLoop, 400);
                return;
            }
        }
        setTimeout(typeLoop, delay);
    }

    typeLoop();
});
