
<table id="ticketTable" class="table">
    <thead>
        <tr>
            <th>ID <i class="fas fa-sort"></i></th>
            <th>Employee Name <i class="fas fa-sort"></i></th>
            <th>Department <i class="fas fa-sort"></i></th>
            <th>Subject <i class="fas fa-sort"></i></th>
            <th>Description <i class="fas fa-sort"></i></th>
            <th>Status <i class="fas fa-sort"></i></th>
            <th>Priority <i class="fas fa-sort"></i></th>
            <th>Category ID <i class="fas fa-sort"></i></th>
            <th>Assigned To <i class="fas fa-sort"></i></th>
            <th>Created At <i class="fas fa-sort"></i></th>
            <th>Duration<i class="fas fa-sort"></i></th>
            <th>Updated At <i class="fas fa-sort"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tickets)): ?>
            <?php foreach ($tickets as $ticket): ?>
                <tr data-status="<?= htmlspecialchars($ticket['status']) ?>">
                    <td><?= htmlspecialchars($ticket['id']) ?></td>
                    <td><?= htmlspecialchars($ticket['employee_name']) ?></td>
                    <td><?= htmlspecialchars($ticket['employee_department']) ?></td>
                    <td><?= htmlspecialchars($ticket['subject']) ?></td>
                    <td><?= htmlspecialchars($ticket['description']) ?></td>
                    <td><?= htmlspecialchars($ticket['status']) ?></td>
                    <td><?= htmlspecialchars($ticket['priority']) ?></td>
                    <td><?= htmlspecialchars($ticket['category_name']) ?></td>
                    <td><?= htmlspecialchars($ticket['assigned_to_name']) ?></td>
                    <td><?= htmlspecialchars($ticket['created_at']) ?></td>
                    <td><?= htmlspecialchars($ticket['start_at']) ?></td>
                    <td><?= htmlspecialchars($ticket['updated_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10" style="text-align: center;">No tickets found</td>
            </tr>
        <?php endif; ?>
    </tbody>

</table>