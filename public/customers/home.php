<?php
session_start();


?>

<?php include('../public/customers/header.php'); ?>
<?php include('../../Classes/Client.php'); ?>

    <input type="checkbox" id="my_modal_1" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Sign up Form</h3>
            <div class="modal-action">
                <form>
                    <input type="text" placeholder="Email" id="email" class="input input-ghost"/>
                    <input type="password" placeholder="Password" id="pass" class="input input-ghost"/><br>
                    <a href="login.php">Already has an account?</a>
                    <br><br>
                    <button class="btn --btn-signup">Signup</button>
                    <label for="my_modal_1" class="btn">Close</label>
                </form>
            </div>
        </div>
    </div>


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
            <label for="my_modal_1" class="btn">Sign up</label>
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

    <center><a href="" style="font-size: 3rem">Available Products</a></center>

    <div style="display: flex; gap: 20px;">
        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                <img
                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                    alt="Shoes" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">Card Title</h2>
                <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                <div class="card-actions justify-end">
                    <button class="btn btn-primary">Buy Now</button>
                </div>
            </div>
        </div>
        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                <img
                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                    alt="Shoes" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">Card Title</h2>
                <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                <div class="card-actions justify-end">
                    <button class="btn btn-primary">Buy Now</button>
                </div>
            </div>
        </div>
        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                <img
                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                    alt="Shoes" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">Card Title</h2>
                <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                <div class="card-actions justify-end">
                    <button class="btn btn-primary">Buy Now</button>
                </div>
            </div>
        </div>
        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                <img
                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                    alt="Shoes" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">Card Title</h2>
                <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                <div class="card-actions justify-end">
                    <button class="btn btn-primary">Buy Now</button>
                </div>
            </div>
        </div>
        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                <img
                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                    alt="Shoes" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">Card Title</h2>
                <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                <div class="card-actions justify-end">
                    <button class="btn btn-primary">Buy Now</button>
                </div>
            </div>
        </div>
        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                <img
                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                    alt="Shoes" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">Card Title</h2>
                <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                <div class="card-actions justify-end">
                    <button class="btn btn-primary">Buy Now</button>
                </div>
            </div>
        </div>
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

    <?php include('../public/customers/footer.php') ?>