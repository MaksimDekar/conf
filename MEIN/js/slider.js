let images = [
    "img/room1.jpg",
    "img/room2.jpg",
    "img/room3.jpg",
    "img/room4.jpg"
];

let index = 0;

function showSlide() {
    document.getElementById("sliderImage").src = images[index];
}

function nextSlide() {
    index++;

    if (index >= images.length) {
        index = 0;
    }

    showSlide();
}

function prevSlide() {
    index--;

    if (index < 0) {
        index = images.length - 1;
    }

    showSlide();
}
setInterval(nextSlide, 3000);