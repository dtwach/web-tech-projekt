<!doctype html>
<html lang="de">
	<head>
		<title>PHP: Basics</title>
        <link rel="stylesheet" href="css/navbar.css">
	</head>
	<body>
        <h2>Registrierung</h2>

        <form action="includes/register_f.php" method="post">
            <?php
            if (!isset($_GET['name'])){
                echo '<input type="text" name="name" placeholder="Benutzername" value=""><br>';
            } else {
                $tname = $_GET['name'];
                echo '<input type="text" name="name" value="'.$tname.'"><br>';
            }
            ?>           
           <input type="text" name="password" placeholder="Passwort" value=""> <br>
           <input type="text" name="password_again" placeholder="Passwort wdh." value=""> <br>
           <button type="submit" name="register_submit">Best&aumltigen</button> <br>
        </form>
        <?php
        isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
        if ($message !== ''){
            switch ($message){
                case 'empty':
                    echo '<p>Eingabefelder sind unvollständig</p>';
                    break;
                case 'even':
                    echo '<p>Passwort stimmt nicht überein</p>';
                    break;
                case 'db';
                    echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                    break;
                case 'taken';
                    echo '<p>Benutzer ist vergeben </p>';
                    break;
                case 'fail';
                    echo '<p>Bitte versuchen Sie es später erneut</p>';
                    break;
            }
        }        
        ?>
    </body>
</html>