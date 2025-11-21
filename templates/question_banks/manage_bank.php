<?php
// /templates/question_banks/manage_banks.php
// -------------------------
// Displays all question banks with Edit/Delete actions
// Pagination added (Prev/Next + numbered + Go-to page)
// -------------------------

$results = $results ?? [
    'pageTitle'   => 'Manage Question Banks',
    'message'     => '',
    'banks'       => [],
    'currentPage' => 1,
    'totalPages'  => 1,
    'total'       => 0,
    'perPage'     => 25
];

$banks       = $results['banks'];
$currentPage = (int)($results['currentPage'] ?? 1);
$totalPages  = (int)($results['totalPages'] ?? 1);
$total       = (int)($results['total'] ?? count($banks));
$perPage     = (int)($results['perPage'] ?? count($banks));
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

                <!-- Page Heading with Add Bank Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>
                    <a href="<?= BASE_URL ?>/admin.php?action=newBank" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Bank
                    </a>
                </div>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Banks Table Card -->
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
                                        <th>Bank Name</th>
                                        <th>Description</th>
                                        <!-- REMOVED total question column -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($banks)): ?>
                                        <?php foreach ($banks as $bank): ?>
                                            <tr>
                                                <td><?= $bank['bank_id'] ?></td>
                                                <td><?= htmlspecialchars($bank['bank_name']) ?></td>
                                                <td><?= htmlspecialchars($bank['description'] ?? '-') ?></td>

                                                <!-- REMOVED: total_questions -->

                                                <td>
                                                    <!-- Edit -->
                                                    <a class="btn btn-sm btn-warning"
                                                       href="<?= BASE_URL ?>/admin.php?action=editBank&id=<?= $bank['bank_id'] ?>">
                                                       <i class="bi bi-pencil-square"></i> Edit
                                                    </a>

                                                    <!-- Delete -->
                                                    <form method="get" action="<?= BASE_URL ?>/admin.php"
                                                          style="display:inline-block; margin:0 4px;"
                                                          onsubmit="return confirm('Are you sure you want to delete this bank?');">
                                                        <input type="hidden" name="action" value="manageBanks">
                                                        <input type="hidden" name="delete" value="<?= $bank['bank_id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No banks found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($totalPages >= 1): ?>
                        <nav aria-label="Pagination" class="mt-4">
                            <ul class="pagination justify-content-center align-items-center">

                                <!-- Prev Button -->
                                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                       href="<?= BASE_URL ?>/admin.php?action=manageBanks&page=<?= max(1, $currentPage - 1) ?>">
                                        <i class="fas fa-angle-left"></i> Prev
                                    </a>
                                </li>

                                <?php
                                // Show page numbers around current page
                                $start = max(1, $currentPage - 2);
                                $end   = min($totalPages, $currentPage + 2);

                                for ($i = $start; $i <= $end; $i++): ?>
                                    <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link"
                                           href="<?= BASE_URL ?>/admin.php?action=manageBanks&page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                       href="<?= BASE_URL ?>/admin.php?action=manageBanks&page=<?= min($totalPages, $currentPage + 1) ?>">
                                        Next <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>

                                <!-- Go To Page -->
                                <li class="page-item ms-3">
                                    <form method="get" action="<?= BASE_URL ?>/admin.php" class="form-inline">
                                        <input type="hidden" name="action" value="manageBanks">
                                        <label for="gotoPage" class="mr-2 mb-0">Go to:</label>
                                        <input type="number" min="1" max="<?= $totalPages ?>"
                                            name="page" id="gotoPage"
                                            class="form-control form-control-sm mr-2"
                                            style="width:70px" value="<?= $currentPage ?>">
                                        <button type="submit" class="btn btn-sm btn-primary">Go</button>
                                    </form>
                                </li>

                            </ul>
                        </nav>
                        <?php endif; ?>
                      
                    </div>
                </div>

            </div> <!-- /.container-fluid -->

        </div> <!-- End of Main Content -->

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>

</div>

