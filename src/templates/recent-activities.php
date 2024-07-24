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
        <?php
        $count = count($_SESSION["loggedUser"]["recentName"]);

        for ($i = 0; $i < $count; $i++) : ?>
            <tr>
                <td><?= htmlspecialchars($_SESSION["loggedUser"]["recentName"][$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($_SESSION["loggedUser"]["recentDate"][$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($_SESSION["loggedUser"]["recentDist"][$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($_SESSION["loggedUser"]["recentTime"][$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($_SESSION["loggedUser"]["recentElev"][$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($_SESSION["loggedUser"]["recentABPM"][$i], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endfor ?>
    </tbody>
</table>