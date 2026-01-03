<?php
// /templates/results/manage_results.php
// -------------------------------------
// Displays all exam results with View/Delete actions
// Includes pagination (Prev/Next + numbered + Go to page)

$resultsList = $results['resultsList'] ?? [];
$currentPage = (int)($results['currentPage'] ?? 1);
$totalPages  = (int)($results['totalPages'] ?? 1);
$total       = count($resultsList);
$perPage     = 25;
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

                <!-- Page Heading with Add Result Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>
                </div>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= (stripos($results['message'], 'success') !== false) ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>' ?>
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Results Table Card -->
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
                                        <th>Exam Title</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Total Marks</th>
                                        <th>Obtained</th>
                                        <th>Started At</th>
					<th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($resultsList)): ?>
                                        <?php foreach ($resultsList as $res): ?>
                                            <tr>
                                                <td><?= $res['result_id'] ?></td>
                                                <td><?= htmlspecialchars($res['exam_title'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($res['student_name'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($res['student_email'] ?? '-') ?></td>
                                                <td><?= $res['total_marks'] ?></td>
                                                <td><?= $res['obtained_marks'] ?></td>
                                                <td><?= htmlspecialchars($res['started_at'] ?? '-') ?></td>
						<td>
						<?php if ($res['result_published'] == 1): ?>
   						   <span class="badge bg-success">Published</span>
						<?php else: ?>
    						   <form method="post" action="<?= BASE_URL ?>/admin.php" style="display:inline;">
        						<input type="hidden" name="action" value="manageResults">
       							<input type="hidden" name="publish_result_id" value="<?= $res['result_id'] ?>">
        						<button class="btn btn-sm btn-success"
                						onclick="return confirm('Publish result for this exam?')">
            							Publish
        						</button>
    						</form>
						<?php endif; ?>
						</td>

                                                <td>
                                                    <!-- View -->
                                                    <a class="btn btn-sm btn-info" 
                                                       href="<?= BASE_URL ?>/admin.php?action=viewResult&id=<?= $res['result_id'] ?>">
                                                       <i class="bi bi-eye"></i> View
                                                    </a>

                                                    <!-- Delete -->
                                                    <form method="get" action="<?= BASE_URL ?>/admin.php" style="display:inline-block; margin:0 4px;"
                                                          onsubmit="return confirm('Are you sure you want to delete this result?');">
                                                        <input type="hidden" name="action" value="manageResults">
                                                        <input type="hidden" name="delete" value="<?= $res['result_id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No results found.</td>
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
                                    <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageResults&page=<?= max(1, $currentPage - 1) ?>">
                                        <i class="fas fa-angle-left"></i> Prev
                                    </a>
                                </li>

                                <?php
                                $start = max(1, $currentPage - 2);
                                $end   = min($totalPages, $currentPage + 2);
                                for ($i = $start; $i <= $end; $i++): ?>
                                    <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageResults&page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageResults&page=<?= min($totalPages, $currentPage + 1) ?>">
                                        Next <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>

                                <!-- Go To Page -->
                                <li class="page-item ms-3">
                                    <form method="get" action="<?= BASE_URL ?>/admin.php" class="form-inline">
                                        <input type="hidden" name="action" value="manageResults">
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
                <!-- End of Results Table Card -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
