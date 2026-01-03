<?php
// /templates/results/view_student_answers.php
// ------------------------------------------------------------
// Admin: View Student Answers for one exam attempt
// ------------------------------------------------------------

include __DIR__ . "/../include/header.php";
include __DIR__ . "/../include/sidebar.php";
?>

<div id="content-wrapper" class="d-flex flex-column">

    <div id="content">

        <?php include __DIR__ . "/../include/topbar.php"; ?>

        <div class="container-fluid">

            <h1 class="h3 mb-3 text-gray-800"><?= $results['pageTitle']; ?></h1>

            <?php if (!empty($results['message'])): ?>
                <div class="alert alert-danger"><?= $results['message']; ?></div>
            <?php endif; ?>

            <?php if (!empty($results['studentInfo'])): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
                    </div>

                    <div class="card-body">
                        <p><strong>Name:</strong> <?= htmlspecialchars($results['studentInfo']['studentName']); ?></p>
                        <p><strong>Exam:</strong> <?= htmlspecialchars($results['studentInfo']['exam_title']); ?></p>
                        <p><strong>Score:</strong> <?= $results['studentInfo']['score'] ?? 0; ?> / <?= $results['studentInfo']['total_marks'] ?? 0; ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Answers Table -->
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Student Answers</h6>
                </div>

                <div class="card-body">
                    <?php if (empty($results['answers'])): ?>
                        <div class="alert alert-info">No answers found!</div>
                    <?php else: ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Selected</th>
                                    <th>Correct Answer</th>
                                    <th>Status</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($results['answers'] as $index => $ans): ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>

                                        <td><?= htmlspecialchars($ans['question_text']); ?></td>

                                        <td><?= htmlspecialchars($ans['selected_option']); ?></td>

                                        <td>
                                            <?php
                                            // Detect correct option
                                            $correct =
                                                ($ans['is_correct'] == 1) ? $ans['selected_option'] : "Wrong Answer";
                                            echo $correct;
                                            ?>
                                        </td>

                                        <td>
                                            <?php if ($ans['is_correct'] == 1): ?>
                                                <span class="badge badge-success">Correct</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Wrong</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>

                    <?php endif; ?>
                </div>

            </div>

        </div>

    </div>

    <?php include __DIR__ . "/../include/footer.php"; ?>

</div>
