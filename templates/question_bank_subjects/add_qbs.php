<?php
// /templates/question_bank_subjects/add_qbs.php
// -------------------------
// View file: Add Question Bank Subject (link a subject to a bank)
require_once __DIR__ . '/../../config/config.php';
?>
<?php include __DIR__ . "/../include/header.php"; ?>

<div id="wrapper">
    <!-- Sidebar -->
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <!-- Navbar -->
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800"><?= $results['pageTitle'] ?? 'Add Subject to Bank' ?></h1>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= stripos($results['message'], 'success')!==false?'alert-success':'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=newQBS">

                            <!-- Select Question Bank -->
                            <div class="form-group mb-3">
                                <label>Question Bank:</label>
                                <select name="bank_id" class="form-control" required>
                                    <option value="">-- Select Bank --</option>
                                    <?php foreach($results['banks'] as $bank): ?>
                                        <option value="<?= $bank['bank_id'] ?>"><?= htmlspecialchars($bank['bank_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Select Subject -->
                            <div class="form-group mb-3">
                                <label>Subject:</label>
                                <select name="subject_id" class="form-control" required>
                                    <option value="">-- Select Subject --</option>
                                    <?php foreach($results['subjects'] as $sub): ?>
                                        <option value="<?= $sub['subject_id'] ?>"><?= htmlspecialchars($sub['subject_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary">Add Link</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageQBS" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>
