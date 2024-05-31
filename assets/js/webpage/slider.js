document.addEventListener('DOMContentLoaded', function () {
    const carouselItems = document.querySelectorAll('.carousel-open');
    let currentIndex = 0;
    const itemCount = carouselItems.length;
    let slideInterval;

    function showNextSlide() {
        carouselItems[currentIndex].checked = false; 
        currentIndex = (currentIndex + 1) % itemCount;
        carouselItems[currentIndex].checked = true; 
    }

    function startSlideShow() {
        slideInterval = setInterval(showNextSlide, 15000); 
    }

    function resetSlideShow() {
        clearInterval(slideInterval); 
        startSlideShow(); 
    }

    startSlideShow();

    const controls = document.querySelectorAll('.carousel-control');
    controls.forEach(control => {
        control.addEventListener('click', function () {

            resetSlideShow();
        });
    });
    carouselItems.forEach(item => {
        item.addEventListener('change', function () {
            currentIndex = Array.from(carouselItems).indexOf(item);
     
            resetSlideShow();
        });
    });
});