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

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $check = "SELECT * FROM booking where room_id = $id";
    $resCheck = mysqli_query($conn, $check);
    if (mysqli_num_rows($resCheck) > 0) {
        ?>
        <script>
            alert("Cant delete because booking of id<?php echo $id ?> exists");
        </script>
        <?php
    } else {

        $sqlDet = "DELETE FROM rooms where room_id = $id";
        $ress = mysqli_query($conn, $sqlDet);
        if ($ress) {
            ?>
            <script>
                alert("Deleted room of id<?php echo $id ?> Successifylly");
            </script>
            <?php
            header("location:roomsetup.php");
        }
    }
}

if (isset($_GET['editRoomId'])) {

    $id = $_GET['editRoomId'];
    $sqlDetails = "SELECT * FROM rooms WHERE room_id = $id";
    $ress = mysqli_query($conn, $sqlDetails);
    if (mysqli_num_rows($ress) > 0) {
        $roomData = mysqli_fetch_assoc($ress);
    }
}

if (isset(($_POST['UpdateStatus']))) {
    $label = $_POST['label'];
    $price = $_POST['price'];
    $no_of_guests = $_POST['no_of_guests'];
    $available = $_POST['available'];
    $available = $_POST['available'];
    $features = $_POST['features'];
    $description = $_POST['description'];
    $image = !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : $roomData['image'];
    $loc = $_FILES['image']['tmp_name'];

    $newLoc = "../Assets/rooms/" . $image;
    $newLocDb = "Assets/rooms/" . $image;
    move_uploaded_file($loc, $newLoc);

    $sql = "UPDATE rooms SET label='$label',price='$price',no_of_guests='$no_of_guests',available='$available',features='$features', description='$description',image='$image' WHERE  room_id='$id'";
    $senres = mysqli_query($conn, $sql);
    if ($senres) {

        header("location: roomsetup.php");

    } else {
        ?>
        <script>
            alert("Failed to update room");
        </script>
        <?php
    }
}

if (isset($_POST['AddRoom'])) {

    $label = $_POST['label'];
    $price = $_POST['price'];
    $no_of_guests = $_POST['no_of_guests'];
    $available = $_POST['available'];
    $available = $_POST['available'];
    $features = $_POST['features'];
    $description = $_POST['description'];
    $image = !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : $roomData['image'];
    $loc = $_FILES['image']['tmp_name'];

    $newLoc = "../Assets/rooms/" . $image;
    $newLocDb = "Assets/rooms/" . $image;
    move_uploaded_file($loc, $newLoc);

   $sql = "INSERT INTO rooms (label, price, no_of_guests, available, features, description, image) VALUEs('$label', '$price', '$no_of_guests', '$available', '$features', '$description', '$image')";
    $senres = mysqli_query($conn, $sql);
    if ($senres) {

        header("location: roomsetup.php");

    } else {
        ?>
        <script>
            alert("Failed to update room");
        </script>
        <?php
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
                        <a href="" class="text-[#E5A819] transition-colors duration-150">Manage Rooms</a>
                        <a href="users.php" class="hover:text-[#E5A819] transition-colors duration-150">Manage Users</a>

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
                 fa-solid fa-hotel"></i></h1>
                <p class="text-black/80 text-4xl md:text-6xl font-semibold text-playfair mt-4">Rooms</p>

            </div>
        </section>
        <section class=" relative  flex items-center max-w-5xl w-5xl mx-auto bg-white py-12">
            <div class="flex justify-between w-full">
                <div>
                    <h1 class="font-semibold text-playfair text-2xl mb-2">Room Management</h1>
                    <p class="font-normal text-poppins text-sm text-black/55">Manage rooms categories, and pricing</p>
                </div>
                <button
                    class="flex items-center gap-2 justify-center rounded-lg h-10 py-2 px-4 text-white bg-[#27447D] transition-color duration-200 hover:bg-[#2651ad] cursor-pointer"><i
                        class="fa-solid fa-plus"></i> <a href="?addRoom=true">Add Room</a></button>
            </div>

        </section>

        <section class="relative pt-8 pb-20 flex flex-col items-center justify-center bg-[#F9FAFB] py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-6 max-w-7xl relative" id="manageRoom">
                Loading.....

            </div>
            <div class="flex mt-4 border border-gray-200" id="pageChange">
                <span class=" border-r border-r-gray-300 h-10 w-10 flex justify-center items-center transition-color duration-200 cursor-pointer hover:bg-[#bbbbbb] bg-[#E7E7E9]" onclick="fetchData(0)"> 1</span>
                <span class=" border-r border-r-gray-300 h-10 w-10 flex justify-center items-center transition-color duration-200 cursor-pointer hover:bg-[#bbbbbb] bg-[#E7E7E9]" onclick="fetchData(6)"> 2</span>
                <span class=" h-10 w-10 flex justify-center items-center transition-color duration-200 cursor-pointer hover:bg-[#bbbbbb] bg-[#E7E7E9]" onclick="fetchData(12)"> 3</span>
            </div>
        </section>
        <div class="inset-0 absolute z-88 <?php echo (isset($_GET['editRoomId']) || isset($_GET['addRoom'])) ? '' : 'hidden'; ?>"
            id="dialog_admin">
            <div class="absolute inset-0 h-screen w-full bg-black/40 flex justify-center items-center ">

                <form class="absolute max-w-lg mx-auto w-lg rounded-lg bg-white p-6" method="POST"
                    enctype="multipart/form-data">

                    <div class="flex w-full flex-col    ">
                        <div class="h-30 relative overflow-hidden  w-full  rounded-lg">
                            <div class="inset-0 absolute z-1 bg-black/40"></div>
                            <?php
                            if (isset($_GET['editRoomId'])) { ?>
                                <img src="../Assets/rooms/<?php echo $roomData['image'] ?>"
                                    class="h-40 w-full object-cover rounded-lg" loading="lazy" alt="">

                            <?php } else {
                                ?>
                                <img src="../Assets/rooms/dummy.jpg" loading="lazy" class="h-40 w-full object-cover rounded-lg" alt="">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <div class="w-[50%]">
                                <h1 class="text-sm text-black/80 font-medium">Name</h1>
                                <input type="text"
                                    class="mt-2 inset-0 w-full p-2 rounded-lg border border-gray-300 focus:outline-blue-500 outline-blue-500 bg-[#FDFDFE] placeholder:text-gray-500 placeholder:text-sm"
                                    placeholder="Enter Name" name="label"
                                    value="<?php echo isset($_GET['editRoomId']) ? $roomData['label'] : "" ?>" required />

                            </div>
                            <div class="w-[50%]">
                                <h1 class="text-sm text-black/80 font-medium">Price</h1>
                                <input type="number" min="0"
                                    class="mt-2 inset-0 w-full p-2 rounded-lg border border-gray-300 focus:outline-blue-500 outline-blue-500 bg-[#FDFDFE] placeholder:text-gray-500 placeholder:text-sm"
                                    placeholder="Price" name="price"
                                    value="<?php echo isset($_GET['editRoomId']) ? $roomData['price'] : " " ?>" required />
                            </div>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <div class="w-[50%]">
                                <h1 class="text-sm text-black/80 font-medium">No of Guests</h1>
                                <input type="number" min="0"
                                    class="mt-2 inset-0 w-full p-2 rounded-lg border border-gray-300 focus:outline-blue-500 outline-blue-500 bg-[#FDFDFE] placeholder:text-gray-500 placeholder:text-sm"
                                    placeholder="No of Guest" name="no_of_guests"
                                    value="<?php echo isset($_GET['editRoomId']) ? $roomData['no_of_guests'] : "" ?>"
                                    required />
                            </div>
                            <div class="w-[50%]">
                                <h1 class="text-sm text-black/80 font-medium">Availibility</h1>
                                <input type="number" min="0"
                                    class="mt-2 inset-0 w-full p-2 rounded-lg border border-gray-300 focus:outline-blue-500 outline-blue-500 bg-[#FDFDFE] placeholder:text-gray-500 placeholder:text-sm"
                                    placeholder="availablity" name="available"
                                    value="<?php echo isset($_GET['editRoomId']) ? $roomData['available'] : "" ?>"
                                    required />
                            </div>
                        </div>
                        <div class="w-full mt-2">
                            <h1 class="text-sm text-black/80 font-medium">Features</h1>
                            <textarea
                                class="mt-2 inset-0 w-full p-2 rounded-lg border border-gray-300 focus:outline-blue-500 outline-blue-500 bg-[#FDFDFE] placeholder:text-gray-500 placeholder:text-sm h-12"
                                placeholder="Features"
                                name="features"><?php echo isset($_GET['editRoomId']) ? $roomData['features'] : "" ?></textarea>
                        </div>
                        <div class="w-full">
                            <h1 class="text-sm text-black/80 font-medium">Description</h1>
                            <textarea
                                class="mt-2 inset-0 w-full p-2 rounded-lg border border-gray-300 focus:outline-blue-500 outline-blue-500 bg-[#FDFDFE] placeholder:text-gray-500 placeholder:text-sm"
                                placeholder="Description"
                                name="description"><?php echo isset($_GET['editRoomId']) ? $roomData['description'] : "" ?></textarea>
                        </div>
                        <div class="w-full">
                            <h1 class="text-sm text-black/80 font-medium">Image</h1>
                            <input type="file" accept=".jpg,.jpeg"
                                class="mt-2 inset-0 w-full p-2 rounded-lg border border-gray-300 focus:outline-blue-500 outline-blue-500 bg-[#FDFDFE] placeholder:text-gray-500 placeholder:text-sm"
                                placeholder="image" name="image" <?php echo isset($_GET['editRoomId']) ? "" : "required" ?> />
                        </div>
                        <div class="flex gap-2 mt-2">

                            <button type="submit"
                                class="mt-2 w-full p-2 flex rounded-lg text-white  justify-center bg-[#193366] hover:bg-[#304775] transition-all duration-200"
                                name="<?php echo isset($_GET['editRoomId']) ? "UpdateStatus" : "AddRoom" ?>"><?php echo isset($_GET['editRoomId']) ? "Update" : "Add Room" ?></button>

                            <a href="roomsetup.php"
                                class="mt-2 w-full p-2 flex rounded-lg text-white  justify-center bg-[#a12727] hover:bg-[#b24c4c] transition-all duration-200"
                                >Cancle</a>
                        </div>

                    </div>
                </form>

            </div>
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
    <script type="module" src="../Js/script.js"></script>
    <script type="module" src="../Js/rooms.js"></script>


</body>

</html>