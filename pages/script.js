const carouselItems = document.querySelectorAll('.carousel-item');
let currentIndex = 0;

function showCarouselItem(index) {
    carouselItems.forEach((item, i) => {
        item.classList.remove('active');
        if (i === index) {
            item.classList.add('active');
        }
    });
}

function nextCarouselItem() {
    currentIndex = (currentIndex + 1) % carouselItems.length; // Mover al siguiente
    showCarouselItem(currentIndex);
}

function prevCarouselItem() {
    currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length; // Mover al anterior
    showCarouselItem(currentIndex);
}

document.getElementById("nextButton").addEventListener("click", nextCarouselItem);
document.getElementById("prevButton").addEventListener("click", prevCarouselItem);

// Mostrar el primer ítem al cargar
showCarouselItem(currentIndex);
