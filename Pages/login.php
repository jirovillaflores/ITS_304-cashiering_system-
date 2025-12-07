<?php include('../includes/header.php') ?>

    
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
    

    <button class="btn" onclick="my_modal_2.showModal()">Login</button>    
    </div>




<?php include('../includes/footer.php') ?>