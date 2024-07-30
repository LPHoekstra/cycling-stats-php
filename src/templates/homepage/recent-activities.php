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
        $count = count($recentActivities->recentName);

        for ($i = 0; $i < $count; $i++) : ?>
            <tr>
                <td><?= htmlspecialchars($recentActivities->recentName[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($recentActivities->recentDate[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($recentActivities->recentDist[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($recentActivities->recentTime[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($recentActivities->recentElev[$i], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($recentActivities->recentABPM[$i], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endfor ?>
    </tbody>
</table>