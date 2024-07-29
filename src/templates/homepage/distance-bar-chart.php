<div class="last-month-chart-contenair">
    <canvas id="last-month-resume"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById("last-month-resume")

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: <?= json_encode($lastMonthActivities->startDate) ?>,
            datasets: [{
                label: "distance last 30 days",
                data: <?= json_encode($lastMonthActivities->distance) ?>,
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