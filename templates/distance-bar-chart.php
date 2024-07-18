<?php // distance chart

require_once(__DIR__ . "/../distance-last-month.php") ?>

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