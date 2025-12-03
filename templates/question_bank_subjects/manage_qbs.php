<?php
// /templates/question_bank_subjects/manage_qbs.php
// -------------------------
// Displays all Question Bank - Subject links with Edit/Delete
// Includes pagination

$results = $results ?? [
    'pageTitle'   => 'Manage Bank Subjects',
    'message'     => '',
    'qbs'         => [],
    'currentPage' => 1,
    'totalPages'  => 1,
    'total'       => 0,
    'perPage'     => 25
];

$qbs        = $results['qbs'];
$currentPage = (int)($results['currentPage'] ?? 1);
$totalPages  = (int)($results['totalPages'] ?? 1);
$total       = (int)($results['total'] ?? count($qbs));
$perPage     = (int)($results['perPage'] ?? count($qbs));
$offset      = ($currentPage - 1) * $perPage;
?>

<?php include __DIR__ . "/../include/header.php"; ?>

<div id="wrapper">
    <!-- Sidebar -->
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

   <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Navbar -->
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">

                <!-- Page Heading with Add Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>
                    <a href="<?= BASE_URL ?>/admin.php?action=newQBS" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Bank-Subject
                    </a>
                </div>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= stripos($results['message'], 'success')!==false?'alert-success':'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Table Card -->
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
                                        <th>Question Bank</th>
                                        <th>Subject</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($qbs)): ?>
                                        <?php foreach ($qbs as $item): ?>
                                            <tr>
                                                <td><?= $item['id'] ?></td>
                                                <td><?= htmlspecialchars($item['bank_name']) ?></td>
                                                <td><?= htmlspecialchars($item['subject_name']) ?></td>
                                                <td>
                                                    <!-- Edit -->
                                                    <a class="btn btn-sm btn-warning" 
                                                       href="<?= BASE_URL ?>/admin.php?action=editQBS&id=<?= $item['id'] ?>">
                                                       <i class="bi bi-pencil-square"></i> Edit
                                                    </a>

                                                    <!-- Delete -->
                                                    <form method="get" action="<?= BASE_URL ?>/admin.php" style="display:inline-block; margin:0 4px;"
                                                          onsubmit="return confirm('Are you sure you want to delete this link?');">
                                                        <input type="hidden" name="action" value="manageQBS">
                                                        <input type="hidden" name="delete" value="<?= $item['id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No bank-subject links found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages >= 1): ?>
                        <nav aria-label="Pagination" class="mt-4">
                            <ul class="pagination justify-content-center align-items-center">

                                <!-- Prev Button -->
                                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageQBS&page=<?= max(1, $currentPage - 1) ?>">
                                        <i class="fas fa-angle-left"></i> Prev
                                    </a>
                                </li>

                                <?php
                                if ($currentPage > 3): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageQBS&page=1">1</a>
                                    </li>
                                    <?php if ($currentPage > 4): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php
                                $start = max(1, $currentPage - 2);
                                $end   = min($totalPages, $currentPage + 2);
                                for ($i = $start; $i <= $end; $i++): ?>
                                    <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageQBS&page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php
                                if ($currentPage < $totalPages - 2):
                                    if ($currentPage < $totalPages - 3): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif; ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageQBS&page=<?= $totalPages ?>"><?= $totalPages ?></a>
                                    </li>
                                <?php endif; ?>

                                <!-- Next Button -->
                                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageQBS&page=<?= min($totalPages, $currentPage + 1) ?>">
                                        Next <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>

                                <!-- Go To Page -->
                                <li class="page-item ms-3">
                                    <form method="get" action="<?= BASE_URL ?>/admin.php" class="form-inline">
                                        <input type="hidden" name="action" value="manageQBS">
                                        <label for="gotoPage" class="mr-2 mb-0">Go to:</label>
                                        <input type="number" min="1" max="<?= $totalPages ?>" name="page" id="gotoPage" class="form-control form-control-sm mr-2" style="width:70px"
                                            value="<?= $currentPage ?>">
                                        <button type="submit" class="btn btn-sm btn-primary">Go</button>
                                    </form>
                                </li>

                            </ul>
                        </nav>
                        <?php endif; ?>

                    </div>
                </div>
                <!-- End of Table Card -->

            </div>

        </div>
        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>
