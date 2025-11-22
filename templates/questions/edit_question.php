<?php
// /templates/questions/edit_question.php
// -------------------------
// View file: Displays Edit Question form
require_once __DIR__ . '/../../config/config.php';
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
                <h1 class="h3 mb-4 text-gray-800"><?= $results['pageTitle'] ?? 'Edit Question' ?></h1>

                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=editQuestion&id=<?= htmlspecialchars($results['question']['question_id']) ?>">

                            <!-- Question Bank -->
                            <div class="form-group mb-3">
                                <label>Question Bank:</label>
                                <select name="bank_id" class="form-control" required>
                                    <option value="">-- Select Bank --</option>
                                    <?php foreach($results['banks'] ?? [] as $bank): ?>
                                        <option value="<?= $bank['bank_id'] ?>" <?= ($results['question']['bank_id'] ?? 0) == $bank['bank_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($bank['bank_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Subject -->
                            <div class="form-group mb-3">
                                <label>Subject:</label>
                                <select name="subject_id" class="form-control" required>
                                    <option value="">-- Select Subject --</option>
                                    <?php foreach($results['subjects'] ?? [] as $subject): ?>
                                        <option value="<?= $subject['subject_id'] ?>" <?= ($results['question']['subject_id'] ?? 0) == $subject['subject_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($subject['subject_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Question Text -->
                            <div class="form-group mb-3">
                                <label>Question Text:</label>
                                <textarea name="question_text" class="form-control" rows="3" required><?= htmlspecialchars($results['question']['question_text'] ?? '') ?></textarea>
                            </div>

                            <!-- Options A–D -->
                            <div class="form-group mb-3">
                                <label>Option A:</label>
                                <input type="text" name="option_a" class="form-control" value="<?= htmlspecialchars($results['question']['option_a'] ?? '') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Option B:</label>
                                <input type="text" name="option_b" class="form-control" value="<?= htmlspecialchars($results['question']['option_b'] ?? '') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Option C:</label>
                                <input type="text" name="option_c" class="form-control" value="<?= htmlspecialchars($results['question']['option_c'] ?? '') ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label>Option D:</label>
                                <input type="text" name="option_d" class="form-control" value="<?= htmlspecialchars($results['question']['option_d'] ?? '') ?>">
                            </div>

                            <!-- Correct Option -->
                            <div class="form-group mb-3">
                                <label>Correct Option:</label>
                                <select name="correct_option" class="form-control" required>
                                    <option value="A" <?= ($results['question']['correct_option'] ?? '')=='A' ? 'selected':'' ?>>A</option>
                                    <option value="B" <?= ($results['question']['correct_option'] ?? '')=='B' ? 'selected':'' ?>>B</option>
                                    <option value="C" <?= ($results['question']['correct_option'] ?? '')=='C' ? 'selected':'' ?>>C</option>
                                    <option value="D" <?= ($results['question']['correct_option'] ?? '')=='D' ? 'selected':'' ?>>D</option>
                                </select>
                            </div>

                            <!-- Marks per Question -->
                            <div class="form-group mb-3">
                                <label>Marks per Question:</label>
                                <input type="number" step="0.01" name="marks_per_question" class="form-control" value="<?= $results['question']['marks_per_question'] ?? 1.0 ?>" required>
                            </div>

                            <!-- Difficulty -->
                            <div class="form-group mb-3">
                                <label>Difficulty:</label>
                                <select name="difficulty" class="form-control" required>
                                    <option value="Easy" <?= ($results['question']['difficulty'] ?? '')=='Easy'?'selected':'' ?>>Easy</option>
                                    <option value="Medium" <?= ($results['question']['difficulty'] ?? '')=='Medium'?'selected':'' ?>>Medium</option>
                                    <option value="Hard" <?= ($results['question']['difficulty'] ?? '')=='Hard'?'selected':'' ?>>Hard</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Question</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageQuestions" class="btn btn-secondary">Cancel</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>
