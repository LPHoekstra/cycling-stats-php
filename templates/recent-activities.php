<?php // distance chart
if (isset($_SESSION["loggedUser"])) :
    require_once(__DIR__ . "/../src/recent-activities.php")
?>
    <h2>Recent Activities</h2>
    <table class="recent-activities-table">
        <thead>
            <tr>
                <th class="recent-activities-table__name">Name</th>
                <th class="recent-activities-table__date">Date</th>
                <th class="recent-activities-table__date">Distance</th>
                <th class="recent-activities-table__date">Time</th>
                <th class="recent-activities-table__date">Elevation</th>
                <th class="recent-activities-table__date">Average BPM</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i <= 9; $i++) : ?>
                <tr>
                    <td><?= $_SESSION["loggedUser"]["recentName"][$i] ?></td>
                    <td><?= $_SESSION["loggedUser"]["recentDate"][$i] ?></td>
                    <td><?= $_SESSION["loggedUser"]["recentDist"][$i] ?></td>
                    <td><?= $_SESSION["loggedUser"]["recentTime"][$i] ?></td>
                    <td><?= $_SESSION["loggedUser"]["recentElev"][$i] ?></td>
                    <td><?= $_SESSION["loggedUser"]["recentABPM"][$i] ?></td>
                </tr>
            <?php endfor ?>
        </tbody>
    </table>
<?php endif ?>