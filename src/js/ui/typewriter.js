export const Typewriter = {
    init(elementId, text, speed) {
        const el = document.getElementById(elementId);
        if (!el) return;
        let i = 0;
        let deleting = false;
        const spd = speed || 80;

        const loop = () => {
            if (!deleting) {
                el.textContent += text.charAt(i);
                i++;
                if (i === text.length) {
                    deleting = true;
                    setTimeout(loop, 1500);
                    return;
                }
            } else {
                el.textContent = text.substring(0, i - 1);
                i--;
                if (i === 0) {
                    deleting = false;
                    setTimeout(loop, 400);
                    return;
                }
            }
            setTimeout(loop, spd);
        };
        loop();
    }
};
