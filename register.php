<?php

require('connection.php');
session_start();




if (isset($_POST['register'])) {

    // get all of the form data 
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwd = $_POST['password'];
    $fullname = $_POST['fname'];



    $user_exist_query = "SELECT * FROM user_registration WHERE userName = '{$username}' OR 'email' = '$email';";         //don't use single quote around the table_name and field_name  
    $result = mysqli_query($con, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0)           //if username or email exist already


        {
            $result_fetch = mysqli_fetch_assoc($result);
            if ($result_fetch['username'] == $_POST['username']) {
                echo "
				<script>
				alert('$result_fetch[username]-Username already taken');
				window.location.href='homepage.php';
				</script>
				";
            } else {
                echo "
				<script>
				alert('$result_fetch[email]-E-mail already registered');
				window.location.href='homepage.php';
				</script>
				";
            }
        } else                                            //if not insert data into the table
        {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  //password encription
            $query = " INSERT INTO user_registration VALUES ('{$fullname}','{$username}','{$email}','{$password}');";
            if (mysqli_query($con, $query)) {
                echo "
		          <script>
		           alert('Registration Complete');
		           window.location.href='homepage.php';
		           </script>
		           ";
            } else {
                echo "
		         <script>
		         alert('Cannot Run Query');
		         window.location.href='homepage.php';
		         </script>
		         ";
            }
        }
    } else {
        echo "
		<script>
		alert('Cannot Run Query');
		window.location.href='homepage.php';
		</script>
		";
    }
}
?>
