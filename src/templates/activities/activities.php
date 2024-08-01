<?php ob_start(); ?>

<h1>Your Activities</h1>
<table class="recent-activities-table">
    <thead>
        <tr>
            <th>When</th>
            <th>Sport Type</th>
            <th>Name</th>
            <th>Distance <br>
                M</th>
            <th>Elev <br>
                M</th>
            <th>Elapsed <br>
                Time</th>
            <th>Moving <br>
                Time</th>
            <th>Start <br>
                Time</th>

            <?php if ($type === "Ride") : ?>
                <th>Speed <br>
                    km/h</th>
                <th>Max <br>
                    Speed <br>
                    km/h</th>

                <?php if ($powerMeter === "Yes") : ?>
                    <th>Pwr <br>
                        W</th>
                    <th>Weighted <br>
                        Avg Pwr <br>
                        W</th>
                    <th>Max <br>
                        Power</th>
                <?php endif ?>

            <?php elseif ($type === "Run") : ?>
                <th>Pace <br>
                    /km</th>
                <th>Elapsed <br>
                    Time <br>
                    Pace <br>
                    /km</th>
                <th>Max <br>
                    Pace <br>
                    /km</th>
                <th>Pace <br>
                    /100m</th>
                <th>Max <br>
                    Pace <br>
                    /100m</th>
            <?php endif ?>

            <th>Cad</th>

            <?php if ($heart === "Yes") : ?>
                <th>Heart</th>
                <th>Max <br>
                    Heart</th>
            <?php endif ?>

            <th>Elev <br>
                High <br>
                M</th>
            <th>Elev <br>
                Low <br>
                M</th>
            <th>Elev/Dist <br>
                m/km</th>
            <th>Elev/Time <br>
                m/h</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>

<?php $content = ob_get_clean();

require_once(__DIR__ . "/../layout.php") ?>