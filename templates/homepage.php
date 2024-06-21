<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cycling Stats</title>
    <link rel="stylesheet" href="./styles/header.css">
    <link rel="stylesheet" href="./styles/global.css">
</head>

<body>
    <!-- header -->
    <?php require_once(__DIR__ . "/header.php") ?>
    <!-- Main -->
    <main>

        <h1>Bienvenue sur Cycling Stats <?= $_SESSION["loggedUser"]["firstname"] ?></h1>
        <?php // distance chart
        if (isset($_SESSION["loggedUser"])) :
            require_once(__DIR__ . "/../src/distance-last-month.php")
        ?>
            <div class="last-month-chart-contenair">
                <canvas id="last-month-resume"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const ctx = document.getElementById("last-month-resume")

                new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: <?= json_encode($_SESSION["loggedUser"]["startDateLast30Act"]) ?>,
                        datasets: [{
                            label: "distance last 30 days",
                            data: <?= json_encode($_SESSION["loggedUser"]["distanceLast30Act"]) ?>,
                            borderWidth: 0,
                            backgroundColor: "rgba(42, 99, 255, 0.8)",
                        }]
                    },
                    options: {
                        aspectRatio: 1 | 4,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                    }
                })
            </script>
        <?php endif ?>
        <!-- test call -->
        <button id="athleteInfo">Call athlete</button>
        <script>
            let bearerToken = "<?= $_SESSION["loggedUser"]["access_token"] ?>"
            document.getElementById("athleteInfo").addEventListener("click", () => {
                fetch("https://www.strava.com/api/v3/athlete/activities", {
                        method: "GET",
                        headers: {
                            Authorization: bearerToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => console.log(data))
                    .catch(error => console.error(error))
            })
        </script>
    </main>
</body>

</html>