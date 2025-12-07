</body>
<script src="../assets/js/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {

        $('.--btn-signup').on('click', function(e) {
            e.preventDefault();
            let email = $('#email').val();
            let password = $('#pass').val();

            alert("Your email is :" + email + " and your password is " + password);

            $.ajax({
                url: '../handlers/signup.php',
                method: "post",
                data: {
                    'signup': true,
                    'email': email,
                    'pass': password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error)
                    } else {
                        alert(response.success)
                    }
                },
                error: function(xhr, response) {
                    console.log(xhr + response)
                }
            })
        })

$('.--btn-login').on('click',function(e){
e.preventDefault();
let email=$('#email').val();
let password = $('#pass').val();


            $.ajax({
                url: '../handlers/login.php',
                method: "post",
                data: {
                    'login': true,
                    'email': email,
                    'pass': password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.redirect) {
                        window.location.href=response.redirect;
                    } else {
                        alert(response.error)
                    }
                },
                error: function(xhr, response) {
                    console.log(xhr + response)
                }
            })
        })
    });


</script>
</html>