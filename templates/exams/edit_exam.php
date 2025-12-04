<?php
// /templates/exams/edit_exam.php
// ---------------------------------
// View file: Edit Exam
// Fully editable like Add Exam
// Includes Assign Students functionality (Class, Individual)
// Question Banks & Subjects with No. of Questions and Difficulty
// Uses SB Admin 2 layout

require_once __DIR__ . '/../../config/config.php';
include __DIR__ . "/../include/header.php";

// Ensure arrays exist to avoid undefined key warnings
$results['subjects'] = $results['subjects'] ?? [];
$results['question_banks'] = $results['question_banks'] ?? [];
$results['exam_question_sources'] = $results['exam_question_sources'] ?? [];
$results['classes'] = $results['classes'] ?? [];
$results['students'] = $results['students'] ?? [];
?>

<div id="wrapper">
    <!-- Sidebar -->
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- Navbar -->
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800"><?= htmlspecialchars($results['pageTitle'] ?? 'Edit Exam') ?></h1>

                <!-- Feedback -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success')!==false)?'alert-success':'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Exam Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=editExam&id=<?= $results['exam_id'] ?>">

                            <!-- Exam Title -->
                            <div class="form-group mb-3">
                                <label>Exam Title:</label>
                                <input type="text" name="exam_title" class="form-control" required value="<?= htmlspecialchars($results['exam_title'] ?? '') ?>">
                            </div>

                            <!-- Exam Description -->
                            <div class="form-group mb-3">
                                <label>Exam Description:</label>
                                <textarea name="exam_description" class="form-control"><?= htmlspecialchars($results['exam_description'] ?? '') ?></textarea>
                            </div>

                            <!-- Duration -->
                            <div class="form-group mb-3">
                                <label>Duration (minutes):</label>
                                <input type="number" name="duration_minutes" class="form-control" min="1" value="<?= htmlspecialchars($results['duration_minutes'] ?? 30) ?>">
                            </div>

                            <!-- Total Marks -->
                            <div class="form-group mb-3">
                                <label>Total Marks:</label>
                                <input type="number" step="0.01" name="total_marks" class="form-control" value="<?= htmlspecialchars($results['total_marks'] ?? '') ?>">
                            </div>

                            <!-- Start & End Date -->
                            <div class="form-group mb-3">
                                <label>Start Date & Time:</label>
                                <input type="datetime-local" name="start_time" class="form-control"
                                    value="<?= !empty($results['start_time']) ? date('Y-m-d\TH:i', strtotime($results['start_time'])) : '' ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label>End Date & Time:</label>
                                <input type="datetime-local" name="end_time" class="form-control"
                                    value="<?= !empty($results['end_time']) ? date('Y-m-d\TH:i', strtotime($results['end_time'])) : '' ?>">
                            </div>

                            <!-- Negative Marking -->
                            <div class="form-group mb-3">
                                <label>Negative Mark per Question:</label>
                                <input type="number" step="0.01" name="negative_marking" class="form-control" value="<?= htmlspecialchars($results['negative_marking'] ?? 0.00) ?>">
                            </div>

                            <!-- Shuffle Questions & Options -->
                            <div class="form-group mb-3">
                                <label>Shuffle Questions:</label>
                                <select name="shuffle_questions" class="form-control">
                                    <option value="1" <?= (isset($results['shuffle_questions']) && $results['shuffle_questions']==1)?'selected':'' ?>>Yes</option>
                                    <option value="0" <?= (isset($results['shuffle_questions']) && $results['shuffle_questions']==0)?'selected':'' ?>>No</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Shuffle Options:</label>
                                <select name="shuffle_options" class="form-control">
                                    <option value="1" <?= (isset($results['shuffle_options']) && $results['shuffle_options']==1)?'selected':'' ?>>Yes</option>
                                    <option value="0" <?= (isset($results['shuffle_options']) && $results['shuffle_options']==0)?'selected':'' ?>>No</option>
                                </select>
                            </div>

                            <!-- Question Sources with No. of Qs and Difficulty -->
                            <div class="form-group mb-3">
                                <label>Select Question Bank & Subjects:</label>
                                <?php if (!empty($results['question_banks'])): ?>
                                    <?php foreach ($results['question_banks'] as $bank): ?>
                                        <div class="mb-2"><strong><?= htmlspecialchars($bank['bank_name']) ?></strong></div>
                                        <?php 
                                        // Fetch subjects for this bank only
                                        $bankSubjects = QuestionBankSubject::getSubjectsByBank($pdo, $bank['bank_id']);
                                        
                                        if (!empty($bankSubjects)):
                                            foreach ($bankSubjects as $sub):
                                                $selectedLimit = $results['exam_question_sources'][$bank['bank_id']][$sub['subject_id']]['limit'] ?? '';
                                                $selectedDiff  = $results['exam_question_sources'][$bank['bank_id']][$sub['subject_id']]['difficulty'] ?? 'Easy';
                                        ?>
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <label><?= htmlspecialchars($sub['subject_name']) ?></label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" min="0" name="exam_question_sources[<?= $bank['bank_id'] ?>][<?= $sub['subject_id'] ?>][limit]" class="form-control" placeholder="No. of Qs" value="<?= htmlspecialchars($selectedLimit) ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="exam_question_sources[<?= $bank['bank_id'] ?>][<?= $sub['subject_id'] ?>][difficulty]" class="form-control">
                                                        <option value="Easy" <?= $selectedDiff=='Easy'?'selected':'' ?>>Easy</option>
                                                        <option value="Medium" <?= $selectedDiff=='Medium'?'selected':'' ?>>Medium</option>
                                                        <option value="Hard" <?= $selectedDiff=='Hard'?'selected':'' ?>>Hard</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php 
                                            endforeach;
                                        else: 
                                            echo "<div class='text-muted ml-3'>No subjects in this bank.</div>";
                                        endif; 
                                        ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-danger">No question banks found. Please add them first.</div>
                                <?php endif; ?>
                            </div>

                            <!-- Total Questions -->
                            <div class="mb-3">
                                <strong>Total Questions Selected: </strong>
                                <span id="totalQuestions">0</span>
                            </div>

                            <!-- Assign Exam To -->
                            <div class="form-group mb-3">
                                <label>Assign Exam To:</label>
                                <select name="assign_type" id="assignType" class="form-control">
                                    <option value="class" <?= (isset($results['assign_type']) && $results['assign_type']=='class')?'selected':'' ?>>Class</option>
                                    <option value="individual" <?= (isset($results['assign_type']) && $results['assign_type']=='individual')?'selected':'' ?>>Individual Students</option>
                                </select>
                            </div>

                            <!-- Classes Dropdown -->
                            <div class="form-group mb-3" id="classSelect" style="display: none;">
                                <label>Select Class:</label>
                                <select name="assign_data[class_id]" class="form-control">
                                    <?php foreach ($results['classes'] as $cls): ?>
                                        <option value="<?= $cls['class_id'] ?>" <?= (isset($results['assign_data']['class_id']) && $results['assign_data']['class_id']==$cls['class_id'])?'selected':'' ?>><?= htmlspecialchars($cls['class_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Students Dropdown -->
                            <div class="form-group mb-3" id="studentSelect" style="display: none;">
                                <label>Select Students:</label>
                                <select name="assign_data[student_ids][]" class="form-control" multiple>
                                    <?php foreach ($results['students'] as $stu): ?>
                                        <option value="<?= $stu['student_id'] ?>" <?= (isset($results['assign_data']['student_ids']) && in_array($stu['student_id'], $results['assign_data']['student_ids']))?'selected':'' ?>>
                                            <?= htmlspecialchars($stu['name']) ?> (<?= $stu['email'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple students.</small>
                            </div>

                            <!-- Exam Link & Password -->
                            <div class="form-group mb-3">
                                <label>Online Exam Link:</label>
                                <input type="text" name="exam_link" class="form-control" readonly value="<?= htmlspecialchars($results['exam_link'] ?? '') ?>">
                                <small class="form-text text-muted">Students will access exam via this link.</small>

                                <input type="text" name="exam_password" class="form-control mt-2" placeholder="Set password">
                                <input type="datetime-local" name="expires_at" class="form-control mt-2" value="<?= !empty($results['expires_at']) ? date('Y-m-d\TH:i', strtotime($results['expires_at'])) : '' ?>">
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary">Update Exam</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageExams" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const assignType = document.getElementById('assignType');
    const classSelect = document.getElementById('classSelect');
    const studentSelect = document.getElementById('studentSelect');
   
    function toggleAssignFields() {
        classSelect.style.display = assignType.value === 'class' ? 'block' : 'none';
        studentSelect.style.display = assignType.value === 'individual' ? 'block' : 'none';
    }

    assignType.addEventListener('change', toggleAssignFields);
    toggleAssignFields(); // initial call

    // Calculate total questions dynamically
    function updateTotalQuestions() {
        let total = 0;
        document.querySelectorAll('input[name*="[limit]"]').forEach(input => {
            let val = parseInt(input.value);
            if (!isNaN(val)) total += val;
        });
        document.getElementById('totalQuestions').innerText = total;
    }
    document.querySelectorAll('input[name*="[limit]"]').forEach(input => {
        input.addEventListener('input', updateTotalQuestions);
    });
    updateTotalQuestions();
});
</script>
