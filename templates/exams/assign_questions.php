<?php
// /templates/exams/assign_questions.php
// -------------------------
// Assign questions to exam
// Shows questions from multiple sources with source info

$results = $results ?? [
    'pageTitle' => 'Assign Questions',
    'questions' => [],
    'assigned'  => [],
    'sources'   => [],
    'exam'      => [],
    'message'   => ''
];

$assignedIds = array_column($results['assigned'], 'question_id');
?>

<?php include __DIR__ . "/../include/header.php"; ?>

<div id="wrapper">
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success')!==false)?'alert-success':'alert-info' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=assignQuestions&id=<?= $results['exam']['exam_id'] ?>">

                            <!-- Show sources info -->
                            <div class="mb-3">
                                <strong>Exam Sources:</strong>
                                <ul>
                                    <?php foreach ($results['sources'] as $source): ?>
                                        <li>
                                            Subject ID: <?= $source['subject_id'] ?? 'All' ?>, 
                                            Difficulty: <?= $source['difficulty'] ?? 'All' ?>, 
                                            Limit: <?= $source['question_limit'] ?? 'All' ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Total questions fetched -->
                            <div class="mb-3">
                                <strong>Total Questions Fetched:</strong> <?= count($results['questions']) ?>
                            </div>

                            <!-- Manual selection -->
                            <div class="mb-3">
                                <label><strong>Manual Selection:</strong></label>
                                <div class="row">
                                    <?php foreach ($results['questions'] as $q): ?>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="question_ids[]" class="form-check-input" id="q<?= $q['question_id'] ?>"
                                                       value="<?= $q['question_id'] ?>"
                                                       <?= in_array($q['question_id'], $assignedIds) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="q<?= $q['question_id'] ?>">
                                                    <?= htmlspecialchars($q['question_text']) ?><br>
                                                    <small>
                                                        A: <?= htmlspecialchars($q['option_a']) ?> |
                                                        B: <?= htmlspecialchars($q['option_b']) ?> |
                                                        C: <?= htmlspecialchars($q['option_c']) ?> |
                                                        D: <?= htmlspecialchars($q['option_d']) ?> |
                                                        Marks: <?= $q['marks_per_question'] ?> |
                                                        Difficulty: <?= $q['difficulty'] ?>
                                                    </small>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Auto-select option -->
                            <div class="form-check mb-3">
                                <input type="checkbox" name="auto_select" class="form-check-input" id="auto_select">
                                <label class="form-check-label" for="auto_select">
                                    Auto Select Questions (Random)
                                </label>
                            </div>

                            <!-- Optional: total questions for auto-select -->
                            <div class="mb-3">
                                <label>Total Questions to assign (Auto):</label>
                                <input type="number" name="total_questions" class="form-control" value="<?= $results['exam']['total_questions'] ?>" min="1">
                            </div>

                            <button type="submit" class="btn btn-primary">Assign Questions</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>
