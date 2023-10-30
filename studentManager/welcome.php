<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            overflow: hidden;
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            background-image: url('background3.jpg'); /* Zamijenite sa svojim linkom */
            background-position: center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #hiddenWrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            opacity: 1;
            animation: fadeOut 1s ease 3s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
            }
        }

        h1 {
            color: white;
            text-align: center;
            font-size: 5em;
        }
    </style>
    <link rel="icon" type="image/png" href="logo.png">
</head>
<body>
    <div id="hiddenWrapper">
        <h1>Welcome</h1>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var hiddenWrapper = document.getElementById("hiddenWrapper");
            setTimeout(function () {
                window.location.href = "index.php";
            }, 4000); // Preusmjeravanje na index.php nakon 5 sekundi
        });
    </script>
</body>
</html>
