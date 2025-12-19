<?php include('../includes/header.php') ?>

    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Sign up Form</h3>
            <div class="modal-action">
                <form method="dialog">
                    <input type="text" placeholder="Email" id="email" class="input input-ghost"/>
                    <input type="password" placeholder="Password" id="pass" class="input input-ghost"/><br>
                    <a href="login.php">Already has an account?</a>
                    <br><br>
                    <button class="btn --btn-signup">Signup</button>    
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="my_modal_2" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Login Form</h3>
            <div class="modal-action">
                <form method="">
                    <input type="text" placeholder="Email" id="email" class="input input-ghost"/>
                    <input type="password" placeholder="Password" id="pass" class="input input-ghost"/><br>
                    <a href="../handlers/signup.php">Forgot Password</a>
                    <br><br>
                    <button class="btn --btn-login">Login</button>    
                    
                </form>
            </div>
        </div>
    </dialog>
    

    

    <div class="navbar bg-base-100 shadow-sm">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                </div>
                <ul
                    tabindex="-1"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li><a>Reviews</a></li>
                    <li>
                        <a>Parent</a>
                        <ul class="p-2">
                            <li><a>Submenu 1</a></li>
                            <li><a>Submenu 2</a></li>
                        </ul>
                    </li>
                    <li><a>Item 3</a></li>
                </ul>
            </div>
            <a class="btn btn-ghost text-xl">R & R Hardware and Construction Supplies</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a>Reviews</a></li>
                <li><a>Visits</a></li>
                <li>
                    <details>
                        <summary>Menu</summary>
                        <ul class="p-2">
                            <li><a>Submenu 1</a></li>
                            <li><a>Submenu 2</a></li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
        <div class="navbar-end">
            <button class="btn" onclick="my_modal_2.showModal()">Login</button>    
    </div>
            <a class="btn" onclick="my_modal_1.showModal()">Sign up</a>
        </div>
    </div>

    <div class="carousel w-full">
        <div id="item1" class="carousel-item w-full --btn-submit">
            <img
                src="https://img.daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.webp"
                class="w-full" />
        </div>
        <div id="item2" class="carousel-item w-full">
            <img
                src="https://img.daisyui.com/images/stock/photo-1609621838510-5ad474b7d25d.webp"
                class="w-full" />
        </div>
        <div id="item3" class="carousel-item w-full">
            <img
                src="https://img.daisyui.com/images/stock/photo-1414694762283-acccc27bca85.webp"
                class="w-full" />
        </div>
        <div id="item4" class="carousel-item w-full">
            <img
                src="https://img.daisyui.com/images/stock/photo-1665553365602-b2fb8e5d1707.webp"
                class="w-full" />
        </div>
    </div>
    <div class="flex w-full justify-center gap-2 py-2">
        <a href="#item1" class="btn btn-xs">1</a>
        <a href="#item2" class="btn btn-xs">2</a>
        <a href="#item3" class="btn btn-xs">3</a>
        <a href="#item4" class="btn btn-xs">4</a>
    </div>

    <footer class="footer sm:footer-horizontal bg-neutral text-neutral-content p-10">
        <nav>
            <h6 class="footer-title">Services</h6>
            <a class="link link-hover">Branding</a>
            <a class="link link-hover">Design</a>
            <a class="link link-hover">Marketing</a>
            <a class="link link-hover">Advertisement</a>
        </nav>
        <nav>
            <h6 class="footer-title">Company</h6>
            <a class="link link-hover">About us</a>
            <a class="link link-hover">Contact</a>
            <a class="link link-hover">Jobs</a>
            <a class="link link-hover">Press kit</a>
        </nav>
        <nav>
            <h6 class="footer-title">Legal</h6>
            <a class="link link-hover">Terms of use</a>
            <a class="link link-hover">Privacy policy</a>
            <a class="link link-hover">Cookie policy</a>
        </nav>
    </footer>

    <?php include('../includes/footer.php') ?>