<?php

require 'header.php';
require 'config.php';

if (isset($_GET['id'])) {
    $_SESSION["id"] = $_GET['id'];
    $_SESSION["ap"] = $_GET['ap'];
}

$_SESSION["user_type"] = "new";

# Checking DB to see if user exists or not

$result = mysqli_query($con, "SELECT * FROM `$table_name` WHERE mac = '" . $_SESSION['id'] . "'");

if ($result->num_rows >= 1) {
    $row = mysqli_fetch_array($result);

    mysqli_close($con);

    $_SESSION["user_type"] = "repeat";
    header("Location: connect.php");
} else {
    mysqli_close($con);
}

?> 
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        <?php echo htmlspecialchars($business_name); ?> WiFi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="../assets/styles/bulma.min.css" />
    <link rel="stylesheet" href="../vendor/fortawesome/font-awesome/css/all.css" />
    <link rel="icon" type="image/png" href="../assets/images/favicomatic/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../assets/images/favicomatic/favicon-16x16.png" sizes="16x16" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/build/css/intlTelInput.css" />
    <script src="../assets/build/js/jquery-3.7.0.min.js"></script>
</head>

<body>
    <div class="page">

        <div class="head">
            <br>
            <figure id="logo">
                <img src="../assets/images/logo.png">
            </figure>
        </div>

        <div class="main">
            <section class="section">
                <div class="container">
                    <div id="contact_form" class="content has-text-centered clr-primary">
                        Please enter your details for WiFi access
                    </div>
                    <br>
                    <form method="post" action="connect.php" onsubmit="return validate()">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" type="text" id="form_font" name="fname" placeholder="First Name" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" type="text" id="form_font" name="lname" placeholder="Last Name" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class=" field">
                            <div class="control has-icons-left">
                                <input class="input" type="email" id="form_font" name="email" placeholder="Email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="name@domain.xxx" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input class="input" type="tel" id="phone" name="phone" placeholder="Phone" required>
                            </div>
                        </div>
                        <span id="error-msg" class="help is-danger"></span>
                        <br>
                        <!--                        <div class="columns is-centered is-mobile">-->
                        <!--                            <div class="control">-->
                        <!--                                <label class="checkbox">-->
                        <!--                                    <input type="checkbox" required>-->
                        <!--                                    I agree to the <a href="policy.php">Terms & Conditions</a>-->
                        <!--                                </label>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        <br>-->
                        <div class="buttons is-centered">
                            <button id="btn" class="button btn-primary">Connect</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <script src="../assets/build/js/intlTelInput.js"></script>
    <script>
        const input = document.querySelector("#phone");
        const button = document.querySelector("#btn");
        const iti = window.intlTelInput(input, {
            initialCountry: "ae",
            hiddenInput: () => ({
                phone: "full_phone",
                country: "country_code"
            }),
            utilsScript: "../assets/build/js/utils.js"
        });
        const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
        const errorMsg = document.querySelector("#error-msg");

        const reset = () => {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
        };

        const showError = (msg) => {
            input.classList.add("error");
            errorMsg.innerHTML = msg;
            errorMsg.classList.remove("hide");
        };

        // on click button: validate
        function validate() {
            reset();
            if (!input.value.trim()) {
                showError("Required");
                return false;
            } else if (iti.isValidNumber()) {
                return true;
            } else {
                const errorCode = iti.getValidationError();
                const msg = errorMap[errorCode] || "Invalid number";
                showError(msg);
                return false;
            }
        }

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    </script>
</body>

</html>
