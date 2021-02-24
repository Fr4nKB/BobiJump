<?php require_once 'navbar.php'; ?>
        <main>
            <form id = "login" action = "signup.php" method = "post" class = "centered">
                <label for="username1">Username</label><br>
                <div><input type="text" name="username" id="username1"></div><br>
                <label for="email">Email</label><br>
                <div><input type="email" name="email" id="email"></div><br>
                <label for="password">Password</label><br>
                <div><input type="password" name="password" id="password"></div><br>
                <input type="submit" id="loginbtn" value="Sign Up">
            </form>
        </main>
    </body>
</html>