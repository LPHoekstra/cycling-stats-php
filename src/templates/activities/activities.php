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

                <?php if ($activities->hasPower) : ?>
                    <th>Pwr <br>
                        W</th>
                    <th>Weighted <br>
                        Avg Pwr <br>
                        W</th>
                    <th>Max <br>
                        Power</th>
                    <?php if ($activities->hasHeartrate) : ?>
                        <th>W/HR</th>
                    <?php endif ?>
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

            <?php if ($activities->hasHeartrate) : ?>
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
            <th>Temp <br>
                °C</th>
            <th>Cal</th>
            <th>Energy <br>
                KJ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($activities->when);

        for ($i = 0; $i < $count; $i++) : ?>
            <tr>
                <td><?= htmlspecialchars($activities->when[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->sportType[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->name[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->distance[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->elev[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->elapsedTime[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->movingTime[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->startTime[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->speed[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->maxSpeed[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->power[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->weightedPower[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->maxPower[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->wattsHeart[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->cadence[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($activities->heart[$i], ENT_QUOTES, 'UTF-8') ?></td>

            </tr>
        <?php endfor ?>
    </tbody>
</table>

<?php $content = ob_get_clean();

require_once(__DIR__ . "/../layout.php") ?>