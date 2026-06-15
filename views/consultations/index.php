<h2>Consultation Requests</h2>

<?php if(empty($items)): ?>

    <p>
        No consultation requests found.
    </p>

<?php else: ?>

<table>

    <thead>

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Mode</th>
        <th>Status</th>
        <th>Date</th>
    </tr>

    </thead>

    <tbody>

    <?php foreach($items as $item): ?>

        <tr>

            <td>
                <?= h($item['id']) ?>
            </td>

            <td>
                <?= h($item['full_name']) ?>
            </td>

            <td>
                <?= h($item['course']) ?>
            </td>

            <td>
                <?= h($item['study_mode']) ?>
            </td>

            <td>
                <?= h($item['status']) ?>
            </td>

            <td>
                <?= h($item['created_at']) ?>
            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>

</table>

<?php endif; ?>