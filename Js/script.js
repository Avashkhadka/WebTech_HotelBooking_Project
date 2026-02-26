const godown = document.querySelector("#godown");
const section2 = document.querySelector("#section2");
const navContainer = document.querySelector("#nav-cont");

window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
        navContainer.classList.remove("text-white");
        navContainer.classList.add("text-black");
        navContainer.classList.add("bg-white");
        document.querySelector("#userName").classList.remove("text-white");
        document.querySelector("#userName").classList.add("text-black");
    } else {
        navContainer.classList.remove("text-black");
        navContainer.classList.add("text-white");
        navContainer.classList.remove("bg-white");
        document.querySelector("#userName").classList.remove("text-black");
        document.querySelector("#userName").classList.add("text-white");
    }
});

godown.addEventListener("click", () => {
    section2.scrollIntoView({
        behavior: "smooth",
    });
});

const whyGuestLoveUs = document.querySelector("#whyGuestLoveUs");

const whyGuestLoveUsArr = [
    {
        icon: "fa-regular fa-user",
        title: "Friendly & Professional Staff",
        desc: "Our warm Nepali hospitality makes you feel at home from the moment you arrive.",
    },
    {
        icon: "fa-solid fa-burst",
        title: "Exceptionally Clean Rooms",
        desc: "Spotless rooms with fresh linens and modern amenities for your comfort.",
    },
    {
        icon: "fa-solid fa-tree",
        title: "Cozy Garden & Terrace",
        desc: "Relax in our peaceful garden oasis with terrace dining and mountain views.",
    },
    {
        icon: "fa-solid fa-utensils",
        title: "Delicious Fresh Food",
        desc: "Home-cooked meals with local and international cuisine to satisfy any palate.",
    },
    {
        icon: "fa-solid fa-location-dot",
        title: "Close to Thamel",
        desc: "Just a 10-minute walk to Kathmandu's vibrant tourist hub and attractions.",
    },
    {
        icon: "fa-solid fa-plane-up",
        title: "Airport Pickup Available",
        desc: "Hassle-free transfers from Tribhuvan Airport directly to our doorstep.",
    },
    {
        icon: "fa-solid fa-mound",
        title: "Perfect for Trekkers",
        desc: "Ideal base for Annapurna, Everest, and Langtang treks. We'll help you plan!",
    },
    {
        icon: "fa-regular fa-calendar",
        title: "Great for Long Stays",
        desc: "Special rates for extended stays. Many guests stay for weeks or months!",
    },
    {
        icon: "fa-regular fa-heart",
        title: "Peaceful Neighborhood",
        desc: "Safe, quiet area away from city chaos while remaining conveniently located.",
    },
];
let htmlElement = "";
whyGuestLoveUsArr.map((el) => {
    htmlElement += `<div class="p-8 bg-white border border-gray-200 hover:shadow-lg rounded-lg group transition-all duration-200">
                        <span class="p-4 rounded-lg scale-110  bg-[#E0E4EB] group-hover:bg-[#193366] transition-all duration-200"
                            ><i class="group-hover:text-white  ${el.icon} transition-all duration-200"></i
                        ></span>
                        <div class="py-4 mt-5">
                            <h1 class="text-xl md:text-2xl text-black/90 font-semibold mb-3">${el.title}</h1>
                            <p class="text-black/50">${el.desc}</p>
                        </div>
                    </div>`;
});
// console.log(htmlElement);
whyGuestLoveUs.innerHTML = htmlElement;

const featuresHome = document.querySelector("#featuresHome");
const featuresHomeArr = [
    "Over 10 years hosting travelers from around the world",
    "Family-run boutique hotel with personal attention",
    "Peaceful area yet walkable to key attractions",
    "Perfect base for trekking adventures",
    "Ideal for Indian Embassy visa travelers",
    "Home-like atmosphere with modern comforts",
];
let featuresHomeElement = "";
featuresHomeArr.map((el) => {
    featuresHomeElement += `<div class="flex gap-2 ">
                                    <span class="p-1 w-8 h-8  inline-flex justify-center items-center bg-[#E3E6EB] text-[#193366] rounded-full"
                                        ><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-check w-4 h-4 text-primary"
                                        >
                                            <path d="M20 6 9 17l-5-5"></path></svg
                                    ></span>
                                    <p class="text-black/75">${el}</p>
                                </div>`;
});
featuresHome.innerHTML=featuresHomeElement
