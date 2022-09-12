<!DOCTYPE html>
<html lang="en-US">

<head>
    <link rel="stylesheet" href="styles.css">
    <title>Ryzen.me</title>
    <link rel="icon" href="https://ryzen.me/images/flavicon.png" />
</head>

<body>
    <div class="wp-site-blocks">
        <figure class="wp-block-image size-full is-resized is-style-default" style="border-radius:0px"><img
                loading="lazy" src="https://ryzen.me/images/ryzen_calligraphy.png" alt="" class="wp-image-25"
                width="302" height="131"
                srcset="https://ryzen.me/images/ryzen_calligraphy.png 302w, https://ryzen.me/images/ryzen_calligraphy.png 300w"
                sizes="(max-width: 302px) 100vw, 302px"></figure>
        <hr class="line"> <br>
        <h2 style="color:#b651e0">Discord: <button onclick="disccopy()" title="Copy" class="minibutton">ryzen#8829
            </button>
            <br>CashApp: <button onclick="cashcopy()" title="Copy" class="minibutton">$Zaiga
            </button> <br>Telegram:
            <button onclick="telecopy()" title="Copy" class="minibutton">@highballer </button> <br> Steam:
            <button onclick="steamtradecopy()" title="Open in new tab" class="minibutton">Steam trade link </button>
        </h2>
        <hr class="line">
    </div>

    <a href="buffshop.php">
        <button type="button" class="shop">Shop</button>
    </a>

    <address>
        <div class="footer">
            <p>Author:Ryzen</p>
            <p>Collaborator: Ezi</p>
            </footer>
    </address>
</body>
<script>
function paypcopy() {
    navigator.clipboard.writeText("Nissangt420@gmail.com");
}

function cashcopy() {
    navigator.clipboard.writeText("$Zaiga");
}

function disccopy() {
    navigator.clipboard.writeText("ryzen#8829");
}

function steamtradecopy() {
    window.open('https://steamcommunity.com/tradeoffer/new/?partner=1092089915&token=o8jkW4va', '_blank');
    alert("Opened in new tab");
}

function telecopy() {
    navigator.clipboard.writeText("@highballer");
    window.open('https://t.me/highballer', '_blank');
    alert('Opened in new tab');
}
</script>

</html>