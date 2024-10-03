
function changeBg() {
  const images = [
    'url("image/1.webp")',
    'url("image/2.jpg")',
    'url("image/3.jpg")',
    'url("image/4.jpg")',
    'url("image/5.jpg")',
    'url("image/6.webp")',


 
  ];
  const section = document.querySelector(".hero");
  const bg = images[Math.floor(Math.random() * images.length)];
  section.style.backgroundImage = bg;
}
setInterval(changeBg, 3000);



const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
  window.scrollY >= 10
    ? header.classList.add("active")
    : header.classList.remove("active");
});



const goTopBtn = document.querySelector("[data-go-top]");

window.addEventListener("scroll", function () {
  window.scrollY >= 500
    ? goTopBtn.classList.add("active")
    : goTopBtn.classList.remove("active");
});
