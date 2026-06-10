/**
 * Hero Carousel - Wijaya Motor
 * Auto-slide carousel with dot navigation and hover pause.
 */
(function () {
    const root = document.getElementById('hero-carousel');
    if (!root) return;

    const slides   = root.querySelectorAll('.carousel-slide');
    const dots     = root.querySelectorAll('.carousel-dot');
    const total    = slides.length;
    const INTERVAL = 15000; // 15 detik
    let current = 0;
    let timerId = null;

    function goTo(index) {
        current = (index + total) % total;

        // Update slides
        slides.forEach((slide, i) => {
            if (i === current) {
                slide.classList.remove('opacity-0', 'pointer-events-none');
                slide.classList.add('opacity-100');
            } else {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        // Update dots
        dots.forEach((dot, i) => {
            if (i === current) {
                dot.classList.remove('w-2', 'bg-white/50');
                dot.classList.add('w-8', 'bg-brand');
            } else {
                dot.classList.remove('w-8', 'bg-brand');
                dot.classList.add('w-2', 'bg-white/50');
            }
        });
    }

    function next()      { goTo(current + 1); }
    function startAuto() { stopAuto(); timerId = setInterval(next, INTERVAL); }
    function stopAuto()  { if (timerId) { clearInterval(timerId); timerId = null; } }

    // Event listener untuk setiap dot
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goTo(index);
            startAuto();
        });
    });

    // Pause saat hover (UX bonus)
    root.addEventListener('mouseenter', stopAuto);
    root.addEventListener('mouseleave', startAuto);

    // Inisialisasi carousel
    goTo(0);
    startAuto();
})();