<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="./mult_table.css" media="all" rel="Stylesheet" type="text/css" />
</head>

<body>

<?php
    if (isset($_COOKIE["fontSize"])) {
        $font_size = $_COOKIE["fontSize"];
        echo "<style>";
        echo "  body {";
        echo "    font-size: " . $font_size . ";";
        echo "  }";

        echo "</style>";
    }

    if (isset($_COOKIE["color"])) {
        $color = $_COOKIE["color"];
        echo "<style>";
        echo "  body {";
        echo "    background-color: " . $color . ";";
        echo "  }";
        echo "</style>";
    }

    if(isset($_POST['set'])){
        if ($_POST['min'] >= $_POST['max']) {
            echo "<p>Min must be greater than max!</p>";
        }
        setcookie("min", $_POST['min'], -1, '/');
        setcookie("max", $_POST['max'], -1, '/');
        unset($_COOKIE["value"]);
        setcookie('value', null, -1, '/'); 
        echo "<p>Range values set!</p>";
    }

    if(isset($_POST['random'])){
        if (!isset($_COOKIE["min"]) || !isset($_COOKIE["max"])) {
            echo "<p>Range must be set!</p>";
        } else {
            $min = $_COOKIE["min"];
            $max = $_COOKIE["max"];
    
            $value = rand($min, $max);
            setcookie("value", $value, -1, '/');
            unset($_COOKIE["counter"]);
            setcookie("counter", 1, -1, '/');
            unset($_COOKIE["arr"]);
            setcookie("arr", json_encode(array()), -1, '/');
            echo "<p>Random set!</p>";
        }
    }

    if(isset($_POST['guess'])){
        if (isset($_COOKIE['value'])) {
            setcookie("counter", $_COOKIE["counter"] + 1, -1, '/');
            $try = $_COOKIE["counter"];
            echo "<p>It is your $try try </p>";
    
            $guessedValue = $_POST['guessed'];

            $arr = json_decode($_COOKIE['arr'], true);
            $message = "$try. Guessed value = $guessedValue";
            array_push($arr, $message);

            setcookie("arr", json_encode($arr), -1, '/');

            echo "<p>Guessing story: </p>";
            foreach ($arr as $i) {
                echo "<p> $i </p>";
            }

            $value = $_COOKIE["value"];
            echo "<p>";
            if ($guessedValue > $value) {
                echo "Guessed value is to big!";
            }
            if ($guessedValue < $value) {
                echo "Guessed value is to small!";
            }
            if ($guessedValue == $value) {
                echo "You won!";
            }
            echo "</p>";
        } else {
            echo "<p>You need to get a random first!</p>";
        }

    }
?>

<form method='post'>
    <label for="min">Select min value for guessing game</label>
    <input required type="text" id="min" name="min">
    <br>
    <label for="max">Select min value for guessing game</label>
    <input required type="text" id="max" name="max">
    <br>
    <input type="submit" name="set" value="set">
</form>

<form method='post'>
    <label for="random">Get new random value to guess</label>
    <input type="submit" name="random" value="random">
</form>

<form method='post'>
    <label for="guess">Guess value</label>
    <input required type="text" id="guessed" name="guessed">
    <input type="submit" name="guess" value="guess">
</form>

</body>
</head>

</html>