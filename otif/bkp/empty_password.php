<!DOCTYPE html>

            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <title>OTIF</title>
                <link rel="stylesheet" href="css/style.css">
                <style type="text/css">
                    img {
                        max-width: 100%;
                        height: auto;
                    }
                </style>
            </head>

            <body>
                <section class="banner"> <img src="img/banner.jpg" alt="OTIF"> </section>
                <section class="container">
                    <div class="login">
                        <h1>Password cannot be empty!</h1>
                        <form method="post" action="/index.php">
                            <p>
                                <input type="text" name="username" value="" placeholder="Username">
                            </p>
                            <p>
                                <input type="password" name="password" value="" placeholder="Password">
                            </p>
                            <p class="error">
                                <mark> Password cannot be empty! </mark>
                            </p>
                            <p class="submit">
                                <input type="submit" name="commit" value="Login">
                            </p>
                        </form>
                    </div>
                </section>