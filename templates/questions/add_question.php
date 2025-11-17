<?php
// /templates/questions/add_question.php
// -------------------------
// View file: Displays Add Question form
require_once __DIR__ . '/../../config/config.php';
?>
<?php include __DIR__ . "/../include/header.php"; ?>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include __DIR__ . "/../include/sidebar.php"; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Navbar -->
            <?php include __DIR__ . "/../include/navbar.php"; ?>
            <!-- End of Navbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">
                    <?= $results['pageTitle'] ?? 'Add Question' ?>
                </h1>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Question Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <!-- Form submits to admin.php?action=newQuestion -->
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=newQuestion">

                            <!-- Question Bank Selection -->
                            <div class="form-group mb-3">
                                <label>Question Bank:</label>
                                <select name="bank_id" class="form-control" required>
                                    <option value="">-- Select Bank --</option>
                                    <?php foreach($results['banks'] ?? [] as $bank): ?>
                                        <option value="<?= $bank['bank_id'] ?>" <?= (isset($results['bank_id']) && $results['bank_id']==$bank['bank_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($bank['bank_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Question Text -->
                            <div class="form-group mb-3">
                                <label>Question Text:</label>
                                <textarea name="question_text" class="form-control" rows="3" required><?= htmlspecialchars($results['question_text'] ?? '') ?></textarea>
                            </div>

                            <!-- Options A–D -->
                            <div class="form-group mb-3">
                                <label>Option A:</label>
                                <input type="text" name="option_a" class="form-control" value="<?= htmlspecialchars($results['option_a'] ?? '') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Option B:</label>
                                <input type="text" name="option_b" class="form-control" value="<?= htmlspecialchars($results['option_b'] ?? '') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Option C:</label>
                                <input type="text" name="option_c" class="form-control" value="<?= htmlspecialchars($results['option_c'] ?? '') ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label>Option D:</label>
                                <input type="text" name="option_d" class="form-control" value="<?= htmlspecialchars($results['option_d'] ?? '') ?>">
                            </div>

                            <!-- Correct Option -->
                            <div class="form-group mb-3">
                                <label>Correct Option:</label>
                                <select name="correct_option" class="form-control" required>
                                    <option value="A" <?= (isset($results['correct_option']) && $results['correct_option']=='A')?'selected':'' ?>>A</option>
                                    <option value="B" <?= (isset($results['correct_option']) && $results['correct_option']=='B')?'selected':'' ?>>B</option>
                                    <option value="C" <?= (isset($results['correct_option']) && $results['correct_option']=='C')?'selected':'' ?>>C</option>
                                    <option value="D" <?= (isset($results['correct_option']) && $results['correct_option']=='D')?'selected':'' ?>>D</option>
                                </select>
                            </div>

                            <!-- Marks & Difficulty -->
                            <div class="form-group mb-3">
                                <label>Marks:</label>
                                <input type="number" step="0.01" name="marks" class="form-control" value="<?= $results['marks'] ?? 1.0 ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Negative Marks:</label>
                                <input type="number" step="0.01" name="negative_marks" class="form-control" value="<?= $results['negative_marks'] ?? 0.0 ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label>Difficulty:</label>
                                <select name="difficulty" class="form-control">
                                    <option value="Easy" <?= (isset($results['difficulty']) && $results['difficulty']=='Easy')?'selected':'' ?>>Easy</option>
                                    <option value="Medium" <?= (isset($results['difficulty']) && $results['difficulty']=='Medium')?'selected':'' ?>>Medium</option>
                                    <option value="Hard" <?= (isset($results['difficulty']) && $results['difficulty']=='Hard')?'selected':'' ?>>Hard</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Add Question</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageQuestions" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>

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
