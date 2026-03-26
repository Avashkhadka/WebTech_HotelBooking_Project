<?php
include '../conn.php';
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("location:http://localhost/webtech_hotelbooking_project/pages/login.php ");
}

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * from rooms where room_id = '$id'";
    $res = mysqli_query($conn, $sql);
    if (!mysqli_num_rows($res) > 0) {
        header("location:http://localhost/webtech_hotelbooking_project/pages/errorpage.php ");
    } {
        $row = mysqli_fetch_assoc($res);
    }
}
$succ_message;
$err_message;

if (isset($_POST['bconfirm'])) {
    $bname = $_POST['bname'];
    $email = $_POST['email'];
    $bpnum = $_POST['bpnum'];
    $bno_of_guests = $_POST['bno_of_guests'];
    $bc_in_date = $_POST['bc_in_date'];
    $bc_out_date = $_POST['bc_out_date'];
    $b_special_req = $_POST['b_special_req'];
    $user_id = $_SESSION['user_id'];
    $room_id = $_GET['id'];
    $checkin = new DateTime($bc_in_date);
    $checkout = new DateTime($bc_out_date);
    $interval = $checkin->diff($checkout);
    $days = $interval->days;
    if ($row['available'] > 0) {


        $sqlBook = "SELECT price from rooms where room_id = $room_id";
        $resBook = mysqli_query($conn, $sqlBook);
        if (mysqli_num_rows($resBook) > 0) {
            $roomd = mysqli_fetch_assoc($resBook);
            $price = $roomd['price'] * 100;
            $total = $price * $days;

        }

        $sql = "UPDATE rooms set available=available-1 where room_id = $room_id";
        $res = mysqli_query($conn, $sql);
        if ($res) {

            $sql = "INSERT INTO `booking`( `room_id`, `user_id`, `status`,`tprice`, `phone_number`, `no_of_guests`, `checkin_date`, `checkout_date`, `special_request`) VALUES ('$room_id','$user_id','pending',$total,'$bpnum','$bno_of_guests','$bc_in_date','$bc_out_date','$b_special_req')";
            $res = mysqli_query($conn, $sql);
            if ($res) {
                $succ_message = "Successifylly. Redirecting to Rooms";

            } else {
                $err_message = "Error. Please try again..";
            }
        } else {
            $err_message = "Error. Please try again...";
        }
    } else {
        $err_message = "Room not available. Please try again..";

    }
    echo ' <script>
                        setTimeout(function() {
                            window.location.href = "http://localhost/webtech_hotelbooking_project/pages/room.php";
                        }, 3000);
                    </script>';


}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rooms</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../Css/style.css" />
</head>

<body>

    <nav class="container mx-auto">
        <div class="fixed top-0 left-0 right-0 z-40 lg:py-4 text-black shadow-sm bg-white transition-all duration-300"
            id="nav-cont">
            <div class="flex justify-between w-full items-center max-w-7xl ml-auto mr-auto px-6 py-2 lg:py-0">
                <a href="../index.php" class="flex gap-2 items-center">
                    <div
                        class="w-10 h-10 text-white font-semibold bg-primary text-2xl rounded-full flex justify-center items-center">
                        H</div>
                    <div class="font-bold text-xl flex flex-col">Aaideu</div>
                </a>
                <div class="lg:block hidden">
                    <div class="flex gap-8 cursor-pointer ml-2 text-sm font-medium">
                        <a href="../index.php" class="hover:text-[#E5A819] transition-colors duration-150">Home</a>
                        <a href="room.php" class="hover:text-[#E5A819] transition-colors duration-150">Rooms</a>
                        <a href="garden.php" class="hover:text-[#E5A819] transition-colors duration-150">Garden &
                            Terrace</a>
                        <a href="cartpage.php" class="hover:text-[#E5A819] transition-colors duration-150">My Cart</a>
                    </div>
                </div>
                <div class="lg:flex gap-8 items-center hidden">
                    <!-- <h1 class="text-sm font-normal cursor-pointer">+977 9841286400</h1> -->
                    <?php
                    if (!$_SESSION['isLogin']) {
                        echo ' <a href="login.php" class=" text-base font-medium text-white transition-all duration-300 bg-primary py-2 px-6 rounded-full">Login</a>';
                    } else {
                        echo '<div class=" flex gap-2 items-center bg-gray-900/10 py-2 px-4 rounded-full text-gray-900  ">
                            <div class=" p-2 h-9 rounded-full text-white bg-primary text-2xl  flex justify-center items-center">' . $_SESSION['username'][0] . '</div>
                            <h1 class="text-base font-medium text-black transition-all duration-300" id="userName">' . $_SESSION['username'] . '</h1>
                        </div><a href="logout.php" class=" text-base font-medium text-white transition-all duration-300 bg-primary py-2 px-6 rounded-full">Logout</a>';
                    }

                    ?>
                </div>
                <div class="lg:hidden flex"><i class="fa-solid fa-bars text-2xl"></i></div>
            </div>
        </div>
    </nav>
    <main class="">

        <div class="bg-[#F7F4ED]">

            <section class="max-w-7xl mx-auto relative pt-32 pb-20 px-6 bg-[#F7F4ED]">

                <a href="room.php"
                    class="text-sm tracking-widest text-left font-medium text-black/50 hover:text-black transition-all duration-300">
                    <i class="fa-solid fa-arrow-left"> </i> Back to Rooms</a>

                <div class="text-center">

                    <h1 class="text-sm tracking-widest  font-medium text-[#E5A819]">BOOK YOUR STAY</h1>
                    <p class="text-black/80 text-4xl md:text-6xl font-semibold text-playfair mt-4">
                        <?php echo $row['label'] ?>
                    </p>

                </div>
            </section>
        </div>
        <div class="bg-[#F9FAFB]">
            <section class="container mx-auto relative pt-20 pb-20 px-6">
                <?php
                if (isset($succ_message) || isset($err_message)) {

                    $bgClass = isset($succ_message) ? "bg-green-300" : "bg-red-300";

                    $message = isset($succ_message) ? $succ_message : $err_message;

                    echo '<div class="w-full flex justify-center items-center ' . $bgClass . ' my-2 p-2">'
                        . $message .
                        '</div>';
                }
                ?>

                <div class="max-w-7xl flex gap-8 mx-auto">

                    <div class="flex-1 w-full sticky top-35">
                        <div
                            class="rounded-xl w-full pb-2 bg-white shadow-sm group hover:shadow-xl transition-all duration-400 sticky top-32 ">

                            <div class="text-white absolute z-1 py-px rounded-full px-4 top-3 right-3 bg-[#193366] ">Rs.
                                <?php echo $row['price'] ?>00/night
                            </div>
                            <div class="rounded-t-lg w-full object-cover h-55 overflow-hidden ">

                                <img src="   <?php echo $row['image'] ?>" alt=""
                                    class="w-full h-60 group-hover:scale-110 transition-all duration-500 object-cover" />
                            </div>
                            <div class="p-6 flex flex-col">
                                <span class="flex items-center gap-2 mb-2">
                                    <i class="fa-solid fa-user-group text-black/60"></i>
                                    <p class="text-sm text-black/70 font-medium">Up to
                                        <?php echo $row['no_of_guests'] ?>
                                        guests
                                    </p>
                                </span>
                                <h1 class="text-playfair font-semibold text-xl text-black/80 mb-2">
                                    <?php echo $row['label'] ?>
                                </h1>
                                <p class="text-black/60 font-medium mb-2 text-sm"> <?php echo $row['description'] ?></p>
                                <h2 class="text-playfair text-lg text-black font-bold mb-2">Amenities</h2>
                                <div class=" text-[#E5A819] ">
                                    <div class="flex items-center gap-2 py-1 rounded-full">
                                        <i class="fa-solid fa-wifi text-xs"></i>
                                        <h6 class="text-base text-black/40 font-medium">Free Wifi</h6>
                                    </div>
                                    <div class="flex items-center gap-2 py-1 rounded-full">
                                        <i class="fa-solid fa-check text-xs"></i>
                                        <h6 class="text-base text-black/40 font-medium">Terrace Access</h6>
                                    </div>
                                    <div class="flex items-center gap-2 py-1 rounded-full">
                                        <i class="fa-solid fa-bath text-xs"></i>
                                        <h6 class="text-base text-black/40 font-medium">Private Bathroom</h6>
                                    </div>
                                    <div class="flex items-center gap-2 py-1 rounded-full">
                                        <i class="fa-solid fa-mug-hot text-xs"></i>
                                        <h6 class="text-base text-black/40 font-medium">Breakfast Included</h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <form class="flex-2" method="POST">

                        <div class="flex flex-col gap-6">
                            <div class="bg-white p-6 shadow-lg rounded-xl">
                                <h1 class="text-playfair text-xl font-semibold">Guest Information</h1>
                                <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                                    <div class="mt-2 space-y-1">
                                        <h2 class="text-sm font-medium text-poppins text-black/85">Full Name*</h2>
                                        <input type="text"
                                            class="inset-0 w-full p-2.5 rounded-lg outline-gray-200 focus:outline-blue-500 border border-gray-200 bg-[#F9FAFB] placeholder:text-gray-500 placeholder:text-sm"
                                            placeholder="Enter Fullname" name="bname" required />
                                    </div>
                                    <div class="mt-2 space-y-1">
                                        <h2 class="text-sm font-medium text-poppins text-black/85">Email *</h2>
                                        <input type="email"
                                            class="inset-0 w-full p-2.5 rounded-lg outline-gray-200 focus:outline-blue-500 border border-gray-200 bg-[#F9FAFB] placeholder:text-gray-500 placeholder:text-sm"
                                            placeholder="example@gmail.com" name="email" required />
                                    </div>
                                    <div class="mt-2 space-y-1">
                                        <h2 class="text-sm font-medium text-poppins text-black/85">Phone Number *</h2>
                                        <input type="number"
                                            class="inset-0 w-full p-2.5 rounded-lg outline-gray-200 focus:outline-blue-500 border border-gray-200 bg-[#F9FAFB] placeholder:text-gray-500 placeholder:text-sm"
                                            placeholder="+977 98XXXXXXXX" name="bpnum" required />
                                    </div>
                                    <div class="mt-2 space-y-1">
                                        <h2 class="text-sm font-medium text-poppins text-black/85">Number of Guests *
                                        </h2>
                                        <input type="number"
                                            class="inset-0 w-full p-2.5 rounded-lg outline-gray-200 focus:outline-blue-500 border border-gray-200 bg-[#F9FAFB] placeholder:text-gray-500 placeholder:text-sm"
                                            placeholder="Enter No of guests" name="bno_of_guests" min="1"
                                            max="<?php echo $row['no_of_guests']; ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-6 shadow-lg rounded-xl">
                                <h1 class="text-playfair text-xl font-semibold"><i
                                        class="text-yellow-400 fa-regular fa-calendar"></i> Booking Dates</h1>
                                <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                                    <div class="mt-2 space-y-1">
                                        <h2 class="text-sm font-medium text-poppins text-black/85">Check-in Date*</h2>
                                        <input type="date"
                                            class="inset-0 w-full p-2.5 rounded-lg outline-gray-200 focus:outline-blue-500 border border-gray-200 bg-[#F9FAFB] placeholder:text-gray-500 placeholder:text-sm"
                                            name="bc_in_date" required id="bc_in_date" onchange="handlechange()"
                                            min="<?php echo date("Y-m-d") ?>" />
                                    </div>
                                    <div class="mt-2 space-y-1">
                                        <h2 class="text-sm font-medium text-poppins text-black/85">Check-out Date *</h2>
                                        <input type="date"
                                            class="inset-0 w-full p-2.5 rounded-lg outline-gray-200 focus:outline-blue-500 border border-gray-200 bg-[#F9FAFB] placeholder:text-gray-500 placeholder:text-sm"
                                            name="bc_out_date" required id="bc_out_date" onchange="handlechange()"
                                            min="<?php echo date("Y-m-d") ?>" />
                                    </div>

                                </div>
                            </div>
                            <div class="bg-white p-6 shadow-lg rounded-xl">
                                <h1 class="text-playfair text-xl font-semibold">
                                    Special Requests</h1>
                                <textarea
                                    class="inset w-full p-2.5 mt-6 h-26 overflow-y-hidden rounded-lg outline-gray-200 focus:outline-blue-500 border border-gray-200 bg-[#F9FAFB] placeholder:text-gray-500 text-sm"
                                    name="b_special_req" placeholder="Any special requests or notes for your stay..."
                                    id=""></textarea>

                            </div>
                            <div class="bg-[#EDF0F3] w-full p-6 shadow-lg rounded-xl border border-gray-300">
                                <h1 class="text-playfair text-xl font-semibold">
                                    Price Summary</h1>
                                <div class="w-full flex justify-between mt-4">
                                    <h2 class="text-sm font-medium text-poppins text-black/60">Number of Guests</h2>
                                    <h1 class="text-sm font-medium text-poppins text-black/90">
                                        Rs.<?php echo $row['price'] ?>00</h1>
                                </div>
                                <div class="w-full flex justify-between mt-4">
                                    <h2 class="text-sm font-medium text-poppins text-black/60">Number of Nights</h2>
                                    <h1 class="text-sm font-medium text-poppins text-black/90" id="noDayDisplay">
                                        0
                                    </h1>

                                </div>
                                <hr class="mt-2 text-gray-300">
                                <div class="w-full flex justify-between mt-4">
                                    <h2 class="text-lg text-poppins text-black font-bold">Total</h2>
                                    <h1 class="text-lg text-yellow-500 font-medium text-poppins " id="totalprice">Rs.0
                                    </h1>
                                </div>
                            </div>
                            <div class="w-full flex gap-6">
                                <button type="submit"
                                    class=" flex-3 py-2 px-4 text-white bg-[#193366] hover:bg-[#2F4775] transition-all duration-200 text-lg rounded-full cursor-pointer"
                                    name="bconfirm">Confirm
                                    Booking</button>
                                <a href="room.php"
                                    class=" text-center flex-1 py-2 px-4 bg-[#F9FAFB] hover:bg-[#E6A819] transition-all duration-200 text-lg border border-gray-300 rounded-full cursor-pointer">Cancle</a>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
    <footer class="bg-[#1B2232] pt-10">
        <div class="p-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-8 justify-between text-white">
                <span>
                    <div class="flex gap-2 text-white font-bold items-center">
                        <h2 class="bg-[#193366] p-2 rounded-full w-10 h-10 flex justify-center items-center text-white">
                            M</h2>
                        <div>
                            <h1>Aaideu</h1>
                        </div>
                    </div>
                    <p class="text-white/60 mt-4">Your quiet home in Kathmandu. Over 10 years of welcoming travelers,
                        trekkers, and adventurers with warm Nepali hospitality.</p>
                    <div class="flex gap-2 mt-4">
                        <span
                            class="cursor-pointer hover:bg-[#1A3161] transition-all duration-200 bg-[#313846] flex justify-center items-center rounded-full h-10 w-10"><i
                                class="text-lg fa-brands fa-facebook-f"></i></span>
                        <span
                            class="cursor-pointer hover:bg-[#1A3161] transition-all duration-200 bg-[#313846] flex justify-center items-center rounded-full h-10 w-10"><i
                                class="text-lg fa-brands fa-instagram"></i></span>
                        <span
                            class="cursor-pointer hover:bg-[#1A3161] transition-all duration-200 bg-[#313846] flex justify-center items-center rounded-full h-10 w-10"><i
                                class="text-lg fa-brands fa-viber"></i></span>
                    </div>
                </span>
                <span>
                    <h1 class="text-lg font-semibold">Quick Links</h1>
                    <div class="flex gap-2 mt-4">
                        <span class="text-white/60 flex flex-col gap-2">
                            <p class="">Home</p>
                            <p class="">Rooms</p>
                            <p class="">Garden & Terrace</p>
                            <p class="">Resturant</p>
                            <p class="">Contact</p>
                        </span>
                    </div>
                </span>
                <span>
                    <h1 class="text-lg font-semibold">Contact Us</h1>
                    <div
                        class="mt-4 flex flex-col text-white/60 gap-4 [&_span]:flex [&_span]:items-center [&_span]:gap-2">
                        <span><i class="fa-solid fa-phone"></i>+977 9841286400</span>
                        <span><i class="fa-regular fa-envelope"></i>avash2063@gmail.com</span>
                        <span><i class="fa-solid fa-location-dot"></i>Kathmandu, Nepal</span>
                    </div>
                </span>
                <span>
                    <h1 class="text-lg font-semibold">Stay Updated</h1>
                    <p class="text-white/60 mt-4">Subscribe for exclusive offers and travel tips.</p>
                    <input type="text" placeholder="Your Email"
                        class="w-full focus:outline-0 p-3 bg-[#313846] border-gray-500 placeholder:text-base mt-2 border rounded-lg" />
                    <button
                        class="w-full py-2 px-4 font-normal bg-[#193366] hover:bg-[#1A3161] transition-all duration-200 text-white text-lg mt-2 cursor-pointer rounded-lg">Subscribe</button>
                </span>
            </div>
            <div class="h-px mt-10 bg-gray-400/30"></div>
            <div class="justify-between flex flex-col md:flex-row text-center text-white/60 py-6">
                <h1>© 2026 Aaideu. All rights reserved.</h1>
                <h1>Created by <a href="https://www.avashkhadka.com.np"
                        class="hover:text-blue-500 cursor-pointer transition-colors duration-200">Avash Khadka</a></h1>
            </div>
        </div>
    </footer>
    <script>


        const bc_in_date = document.querySelector("#bc_in_date");
        const bc_out_date = document.querySelector("#bc_out_date");
        const noDayDisplay = document.querySelector("#noDayDisplay");
        const totalprice = document.querySelector("#totalprice");
        function handlechange() {
            if (bc_in_date.value && bc_out_date.value) {
                const checkin = new Date(bc_in_date.value);
                const checkout = new Date(bc_out_date.value);
                const diff = checkout - checkin;
                const days = diff / (1000 * 60 * 60 * 24);
                noDayDisplay.innerHTML = days;
                const price = <?php echo $row['price'] ?> * 100;

                totalprice.innerHTML = `<h1>Rs.${days * price}</h1>`;
            }
        }

    </script>
</body>

</html>