<?php
include '../conn.php';
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("location:http://localhost/webtech_hotelbooking_project/pages/login.php ");
} else {
    if (!($_SESSION['role'] == 'admin')) {
        header("location:http://localhost/webtech_hotelbooking_project/index.php");
    }
}

$sql = "SELECT * from users";
$res = mysqli_query($conn, $sql);
if (!mysqli_num_rows($res) > 0) {
    header("location:http://localhost/webtech_hotelbooking_project/pages/errorpage.php ");

}

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "UPDATE users set status='DEACTIVATED' where id =$id ";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header("location: users.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Aaideu - Hotel Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../Css/style.css" />
</head>

<body class="relative">
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
                        <a href="adminpage.php" class="hover:text-[#E5A819] transition-colors duration-150">Bookings</a>
                        <a href="roomsetup.php" class="hover:text-[#E5A819] transition-colors duration-150">Manage
                            Rooms</a>
                        <a href="users.php" class="text-[#E5A819] transition-colors duration-150">Manage Users</a>

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
    <main>
        <section class="relative pt-32 pb-20 flex items-center justify-center bg-[#F7F4ED]">
            <div class="text-center">
                <h1 class="text-sm tracking-widest text-black/70 font-medium"><i class="text-6xl
                 fa-solid fa-users"></i></h1>
                <p class="text-black/80 text-4xl md:text-6xl font-semibold text-playfair mt-4">Users</p>

            </div>
        </section>
        <section class="relative pt-8 pb-20 flex items-center justify-center bg-white">
            <div class="w-7xl max-w-7xl mx-auto rounded-lg">

                <table class=" border-collapse w-full">
                    <tr class="bg-[#F7F8F9] [&>th]:p-3  border border-gray-300 rounded-lg ">
                        <th class="text-left">ID</th>
                        <th class="text-left">Customer</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Join Date</th>
                        <th class="">Action</th>
                    </tr>
                    <?php
                    $vip = mysqli_query($conn, "SELECT * FROM users WHERE status='VIP'");
                    while ($row = mysqli_fetch_assoc($vip)) {
                         echo "
                            <tr class='text-center border border-gray-300 hover:bg-[#FAFBFC] transition-colors duration-200'>
                        <td class='p-3 text-left'>" . $row['id'] . "</td>
                        <td class='p-3 text-left'>" . $row['username'] . "</td>
                        <td class='p-3 text-left'>" . $row['email'] . "</td>
                        <td class='p-3 text-left'> <div class='text-sm py-1 text-center px-4 w-30 font-medium rounded-full bg-yellow-300 text-[#b45309]'>" . $row['status'] . "</div></td>
                        <td class='p-3 text-left'>" . $row['email'] . "</td>
                        
                     
                        <td class='p-3 '><div><a href='?deleteid=" . $row['id'] . "' class='bg-[#FEE2E2] py-px px-4 rounded-full cursor-pointer hover:bg-red-200 text-red-500' ><i class='fa-regular fa-trash-can'></i></a>

                        </div></td>
                        </tr>
                        ";
                    }


                    ?>
                    <?php
                    $active = mysqli_query($conn, "SELECT * FROM users WHERE status='ACTIVE'");
                    while ($row = mysqli_fetch_assoc($active)) {
                         echo "
                            <tr class='text-center border border-gray-300 hover:bg-[#FAFBFC] transition-colors duration-200'>
                        <td class='p-3 text-left'>" . $row['id'] . "</td>
                        <td class='p-3 text-left'>" . $row['username'] . "</td>
                        <td class='p-3 text-left'>" . $row['email'] . "</td>
                        <td class='p-3 text-left'> <div class='text-sm py-1 text-center px-4 w-30  font-medium rounded-full bg-[#D1FAE5] text-[#407857]'>" . $row['status'] . "</div></td>
                        <td class='p-3 text-left'>" . $row['email'] . "</td>
                        
                     
                        <td class='p-3 '><div><a href='?deleteid=" . $row['id'] . "' class='bg-[#FEE2E2] py-px px-4 rounded-full cursor-pointer hover:bg-red-200 text-red-500' ><i class='fa-regular fa-trash-can'></i></a>

                        </div></td>
                        </tr>
                        ";
                    }


                    ?>
                    <?php
                    $deact = mysqli_query($conn, "SELECT * FROM users WHERE status='DEACTIVATED'");
                    while ($row = mysqli_fetch_assoc($deact)) {
                        $statClas = $row['status'] == 'DEACTIVATED' ? "bg-[#FEE2E2] text-[#b91c1c]" : ($row['status'] == 'VIP' ? "bg-yellow-300 text-[#b45309]" : ($row['status'] == 'ACTIVE' ? "bg-[#D1FAE5] text-[#407857]" : ""));
                        echo "
                            <tr class='text-center border border-gray-300 hover:bg-[#FAFBFC] transition-colors duration-200'>
                        <td class='p-3 text-left'>" . $row['id'] . "</td>
                        <td class='p-3 text-left'>" . $row['username'] . "</td>
                        <td class='p-3 text-left'>" . $row['email'] . "</td>
                        <td class='p-3 text-left'> <div class='text-sm py-1 text-center px-4 w-30 font-medium rounded-full  bg-[#FEE2E2] text-[#b91c1c]'>" . $row['status'] . "</div></td>
                        <td class='p-3 text-left'>" . $row['email'] . "</td>
                        
                     
                        <td class='p-3 '><div><a href='?deleteid=" . $row['id'] . "' class='bg-[#FEE2E2] py-px px-4 rounded-full cursor-pointer hover:bg-red-200 text-red-500' ><i class='fa-regular fa-trash-can'></i></a>

                        </div></td>
                        </tr>
                        ";
                    }


                    ?>
                </table>
            </div>
        </section>
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
    <script type="module" src="../Js/script.js"></script>
    <script>

        window.closeMenu = () => {
            window.location.href = 'adminpage.php';

        }





    </script>
</body>

</html>