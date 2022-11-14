<!DOCTYPE html>
<html lang="en-US">
<?php
$invval = 0;
$servername = "localhost";
$username = "readonly";
$password = "secret_password";
$db = "prices";

$conn = new mysqli($servername, $username, $password, $db);


if ($conn->connect_error){
	die("Connection failed: ". $conn->connect_error);
}
?>

<head>
    <title>Ryzen.me inventory checker</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="images/flavicon.png" />
    <a href="index.php"><button type="button" class="headbutton">Home</button></a>
    <a href="inventory.php"><button type="button" class="headbutton" style="background-color:purple">Inventory price
            check</button></a>
    <a href="search.php"><button type="button" class="headbutton">Buff database search</button></a>
    <a href="exchange.php"><button type="button" class="headbutton">Exchange</button></a>
</head>
<hr class="headline" style="top: -10px;">
<hr class="headline" style="bottom: -10px;">
<style>
body {
    background-image: url("images/Background.png");
    overflow: overlay;
}

::-webkit-scrollbar {
    width: 5px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.2)
}

::-webkit-scrollbar-thumb {
    background: #b651e0;
    border: 1px solid black;
    border-radius: 3px;
}
</style>

<body>
    <br><br>
    <img src="images/ryzen_calligraphy.png" class="cover">
    <hr class="line"> <br>
    <form name="steamidmenu" action="" method="get">
        <label for="steamid">Enter steam id:</label>
        <input type="text" id="steamid" name="steamid" class="input"
            value="<?php echo htmlspecialchars($_GET['steamid']); ?>">
        <?php
        echo '        <a href="inventory.php?steamid="'.$_GET["steamid"].'">
            <button class="minibutton">search</button>
        </a>'
            ?>
    </form>
    <form name="skins" onchange="">
        <?php
            $id = $_GET['steamid'];
            $items = 0;
            $curl = curl_init();
            curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
            if (strlen($id) != 17){
                $id_url = "https://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=74B813881CCD0CB19AC3FBBF096EBFA9&vanityurl=" . $id . "";
                curl_setopt($curl, CURLOPT_URL,$id_url);
                $id_data = curl_exec($curl);
                if($e = curl_error($curl)) {
                    $error = "Error obtaining steam ID";
                } else{
                    $id_json = json_decode($id_data,true);
                    $id = $id_json->response->steamid; 
                }
            }
            $url = "https://steamcommunity.com/profiles/$id/inventory/json/730/2";
            curl_setopt($curl, CURLOPT_URL,$url);
            $jsondata = curl_exec($curl);
            if($e = curl_error($curl) || $error !=null) {
                $error = "Error obtaining steam inventory";
            } else{
                $inventory = json_decode($jsondata, true);
            if ($inventory == null && $id_json != null)
            {
                $error = "You have been timed out by steam, give it a minute";
            }
            else {
                echo '<label for="value">Inventory Value: </label>';
                echo '<input type="text" id="value" name="value" value="0.0" class="hiddeninput" size="1" readonly>';
                echo '<label for="value"> | for </label>';
                echo '<input type="text" id="items" name="items" value="0" class="hiddeninput" size="1" readonly>';
                echo '<label for="value"> Items</label> <br>';
                echo '<hr class="line"> <br>';
                echo '<table>';
                echo '<tr><th>Image</th><th>Name</th><th>price</th><th>TradeHold</th></tr>';
                foreach ($inventory->rgDescriptions as $value => $v) {
                    $name = $v->market_hash_name;
                    $icon_url = $v->icon_url;
                    $sql = 'select ifnull( (select price from prices where name="' . $name . '") ,"0.0")';
                    $result = $conn->prepare($sql);
                    //$result->bind_param("d",$price);
                    $result->execute();
                    $result->store_result();
                    $result->bind_result($price);
                    $result->fetch();
                    $name = str_replace('StatTrak™', 'ST™', $name);
                    $name = str_replace('Factory New', 'FN', $name);
                    $name = str_replace('Minimal Wear', 'MW', $name);
                    $name = str_replace('Field-Tested', 'FT', $name);
                    $name = str_replace('Well-Worn', 'WW', $name);
                    $name = str_replace('Battle Scarred', 'BS', $name);
                    $image = '<img src = "http://steamcommunity-a.akamaihd.net/economy/image/' . $icon_url . '" class="icon" alt="' . $name . '">';
                    if (isset($v->cache_expiration)) {
                        $hold = substr($v->cache_expiration, 0, 10);
                        echo '<tr><td>' . $image . '</td><td>' . $name . '</td><td>$' . $price . '</td><td>' . $hold . '</td></tr>';
                    }
                    else {
                        echo '<tr><td>' . $image . '</td><td>' . $name . '</td><td>$' . $price . '</td><td>Tradeable</td></tr>';
                    }
                    $invval = $invval + $price;
                    $items = $items + 1;
                    echo
                        '<script type="text/javascript">
                        document.getElementById("value").setAttribute("value","' . $invval . '");
                        document.getElementById("value").setAttribute("size","' . strlen((string)$invval) . '");
                        document.getElementById("items").setAttribute("value","' . $items . '")
                        document.getElementById("items").setAttribute("size","' . strlen((string)$items) . '");
                        </script>';

                    }
                    echo '</table>';
                    echo '<p>Inventory value: ' . $invval . '</p>';
}}
curl_close($curl);
if (isset($error)){
    echo '<p>An error has been caught:</p>';
    echo '<p>'.$error.'</p>';
}
        ?>
    </form>
    <br>
    <hr class="line"> <br>
    <br>
    <address>
        <div class="footer">
            <p>By using our services you agree to our TOS</p>
            </footer>
    </address>
    <a href="TOS.php">
        <button title="TOS" class="tos">TOS</button>
    </a>
    <a href="privpos.php">
        <button title="privpos" class="privpos">Privacy Policy</button>
    </a>
</body>
<script>
</script>

</html>
