window.addEventListener("DOMContentLoaded", () => {
    const manageRoom = document.querySelector("#manageRoom");
    let roomData = "";
    window.fetchData = async (offset) => {
        let res = await fetch(`../Pages/fetchrooms.php?offset=${offset}`);
        let data = await res.json();
        roomData = data
            .map((el, i) => {
                return ` <div class="group rounded-xl pb-2 relative bg-white shadow-sm group  duration-400">
                               <div class="rounded-t-lg w-80 object-cover h-45 overflow-hidden ">

                            <img src="../Assets/rooms/${el.image}" loading="lazy" alt=""   class="group-hover:scale-110 transition-transform duration-500 w-full h-45  object-cover"/>
                        </div>
                        <div class="p-4 flex flex-col">
                        <div class="flex justify-between items-center">
                        <h1 class="text-playfair font-semibold text-lg text-black/80 mb-2">${el.label}</h1>
                        <span class="py-1 px-3 font-medium text-sm rounded-full flex items-center  ${el.available == "0" ? "bg-[#DBEAFE] text-[#1d4ed8]" : "bg-[#D1FAE5] text-[#047857]"}">${el.available != "0" ? "available" : "occupied"}
                        ${"[" + el.available + "]"}
                        </span>
                        </div>
                            <span class="flex items-center gap-2 mb-2">
                                <p class="text-sm text-black/70 font-medium">Up to ${el.no_of_guests} guests</p>
                            </span>
                            <div class="flex justify-between items-center">
                            <span><b class="text-lg text-black">Rs.${el.price}</b>/night</span>
                            <div class="flex gap-2">
                                <span class="p-2 hover:bg-yellow-500 rounded-lg"><a href="?editRoomId=${el.room_id}"><i class="text-gray-500 fa-lg fa-regular fa-pen-to-square"></i></a></span>
                                <span class="p-2 hover:bg-yellow-500 rounded-lg"><a href="?deleteid=${el.room_id}"><i class="text-red-500 fa-lg fa-regular fa-trash-can"></i></a></span>
                            </div>
                            </div>                            
                        </div>
                    </div>`;
            })
            .join("");
        manageRoom.innerHTML = roomData;
    };
    fetchData(0);
});
