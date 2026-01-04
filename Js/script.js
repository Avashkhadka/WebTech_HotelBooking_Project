const godown = document.querySelector("#godown");
const section2 = document.querySelector("#section2");
const navContainer = document.querySelector("#nav-cont");

window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
        navContainer.classList.remove("text-white");
        navContainer.classList.add("text-black");
        navContainer.classList.add("bg-white/90");
        document.querySelector("#userName").classList.remove("text-white") 
        document.querySelector("#userName").classList.add("text-black")
    } else {
        navContainer.classList.remove("text-black");
        navContainer.classList.add("text-white");
        navContainer.classList.remove("bg-white/90");
        document.querySelector("#userName").classList.remove("text-black")
        document.querySelector("#userName").classList.add("text-white")
    }
});

godown.addEventListener("click", () => {
    section2.scrollIntoView({
        behavior: "smooth",
    });
});
