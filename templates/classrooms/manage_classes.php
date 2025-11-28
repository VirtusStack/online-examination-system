<?php
// /templates/classrooms/manage_classes.php
$results = $results ?? [
    'pageTitle'   => 'Manage Classes',
    'message'     => '',
    'classes'     => [],
    'currentPage' => 1,
    'totalPages'  => 1,
    'total'       => 0,
    'perPage'     => 25
];

$classes     = $results['classes'];
$currentPage = (int)($results['currentPage'] ?? 1);
$totalPages  = (int)($results['totalPages'] ?? 1);
$total       = (int)($results['total'] ?? count($classes));
$perPage     = (int)($results['perPage'] ?? count($classes));
$offset      = ($currentPage - 1) * $perPage;
?>

<?php include __DIR__ . "/../include/header.php"; ?>

<div id="wrapper">
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>
                    <a href="<?= BASE_URL ?>/admin.php?action=newClassroom" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Class
                    </a>
                </div>

                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show">
                        <?= (stripos($results['message'], 'success') !== false) ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>' ?>
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Class Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($classes)): ?>
                                        <?php foreach ($classes as $cls): ?>
                                            <tr>
                                                <td><?= $cls['class_id'] ?></td>
                                                <td><?= htmlspecialchars($cls['class_name']) ?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-warning" href="<?= BASE_URL ?>/admin.php?action=editClassroom&id=<?= $cls['class_id'] ?>">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <form method="get" action="<?= BASE_URL ?>/admin.php" style="display:inline-block; margin:0 4px;" onsubmit="return confirm('Are you sure?');">
                                                        <input type="hidden" name="action" value="manageClasses">
                                                        <input type="hidden" name="delete" value="<?= $cls['class_id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No classes found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($totalPages >= 1): ?>
                        <nav aria-label="Pagination" class="mt-4">
                            <ul class="pagination justify-content-center align-items-center">
                                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageClasses&page=<?= max(1, $currentPage-1) ?>">
                                        <i class="fas fa-angle-left"></i> Prev
                                    </a>
                                </li>

                                <?php
                                $start = max(1, $currentPage - 2);
                                $end = min($totalPages, $currentPage + 2);
                                for ($i=$start; $i<=$end; $i++): ?>
                                    <li class="page-item <?= ($i==$currentPage)?'active':'' ?>">
                                        <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageClasses&page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageClasses&page=<?= min($totalPages,$currentPage+1) ?>">
                                        Next <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>

                                <li class="page-item ms-3">
                                    <form method="get" action="<?= BASE_URL ?>/admin.php" class="form-inline">
                                        <input type="hidden" name="action" value="manageClasses">
                                        <label for="gotoPage" class="mr-2 mb-0">Go to:</label>
                                        <input type="number" min="1" max="<?= $totalPages ?>" name="page" id="gotoPage" class="form-control form-control-sm mr-2" style="width:70px" value="<?= $currentPage ?>">
                                        <button type="submit" class="btn btn-sm btn-primary">Go</button>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>

        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>
