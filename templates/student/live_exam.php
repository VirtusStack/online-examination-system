<?php
// /templates/student/live_exam.php
// -----------------------------------------------------------
// Live Exam Page
// Shows questions, timer, 5 questions per page, navigation
// Works with: student.php?action=liveExam&exam_id=ID
// Full-screen, no sidebar
// -----------------------------------------------------------

require_once __DIR__ . '/../../config/config.php';

// Include header only
include __DIR__ . "/header.php";
// Sidebar hidden for exam
// include __DIR__ . "/sidebar.php";

?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?php include __DIR__ . "/topbar.php"; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid px-5 py-4" style="max-width: 100%; width:100vw;">

            <h1 class="h3 mb-4 text-gray-800 text-center">
                <?= htmlspecialchars($exam['exam_title'] ?? 'Exam'); ?>
            </h1>

            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <span>
                                Questions <span id="currentQuestion">1</span> - <span id="currentQuestionEnd">5</span> of <?= count($questions); ?>
                            </span>
                            <span>
                                Time Left: <b id="timer"><?= intval($exam['duration_minutes'] ?? 30); ?>:00</b>
                            </span>
                        </div>

                        <div class="card-body">

                            <!-- Exam Form -->
                            <form id="examForm" method="post" action="student.php?action=submitExam&exam_id=<?= intval($exam['exam_id'] ?? 0); ?>">
                                <!-- Pass link_id to controller for saving results -->
                                <input type="hidden" name="link_id" value="<?= intval($link['link_id'] ?? 0); ?>">
<input type="hidden" name="link_id" value="<?= intval($link['link_id']); ?>">

                                <?php foreach ($questions as $index => $q): ?>
                                    <div class="question-block mb-4 <?= $index < 5 ? '' : 'd-none'; ?>" data-index="<?= $index; ?>">
                                        <p><strong><?= ($index + 1) . ". " . htmlspecialchars($q['question_text']); ?></strong></p>

                                        <?php foreach ($q['options'] as $optKey => $optText): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="answers[<?= $q['question_id']; ?>]" value="<?= $optKey; ?>" id="q<?= $q['question_id']; ?>_<?= $optKey; ?>">
                                                <label class="form-check-label" for="q<?= $q['question_id']; ?>_<?= $optKey; ?>">
                                                    <?= htmlspecialchars($optText); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Navigation Buttons -->
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" id="prevBtn" class="btn btn-secondary">Previous</button>
                                    <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
                                    <button type="submit" id="submitBtn" class="btn btn-success d-none">Submit Exam</button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div> <!-- row end -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

</div>
<!-- End of Content Wrapper -->

<!-- JS for question navigation (5 per page) and timer -->
<script>
let currentIndex = 0; // Tracks the first question of the current page
const totalQuestions = <?= count($questions); ?>;
const questionBlocks = document.querySelectorAll('.question-block');
const pageSize = 5; // 5 questions per page

// Function to show a page of questions
function showQuestions(start) {
    questionBlocks.forEach((block, i) => {
        block.classList.toggle('d-none', i < start || i >= start + pageSize);
    });

    // Update page number display
    document.getElementById('currentQuestion').textContent = start + 1;
    document.getElementById('currentQuestionEnd').textContent = Math.min(start + pageSize, totalQuestions);

    // Show/hide buttons
    document.getElementById('prevBtn').style.display = start === 0 ? 'none' : 'inline-block';
    document.getElementById('nextBtn').style.display = start + pageSize >= totalQuestions ? 'none' : 'inline-block';
    document.getElementById('submitBtn').classList.toggle('d-none', start + pageSize < totalQuestions);
}

// Previous/Next button click handlers
document.getElementById('prevBtn').addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex -= pageSize;
        if (currentIndex < 0) currentIndex = 0;
        showQuestions(currentIndex);
    }
});

document.getElementById('nextBtn').addEventListener('click', () => {
    if (currentIndex + pageSize < totalQuestions) {
        currentIndex += pageSize;
        showQuestions(currentIndex);
    }
});

// Initialize first page
showQuestions(currentIndex);

// Timer countdown
let duration = <?= intval($exam['duration_minutes'] ?? 30); ?> * 60; // seconds
const timerEl = document.getElementById('timer');

const countdown = setInterval(() => {
    const minutes = Math.floor(duration / 60);
    const seconds = duration % 60;
    timerEl.textContent = minutes + ":" + (seconds < 10 ? '0' + seconds : seconds);
    if (--duration < 0) {
        clearInterval(countdown);
        alert('Time is up! Submitting exam...');
        document.getElementById('examForm').submit();
    }
}, 1000);

/* -----------------------------------------------------------
   TAB SWITCH PROTECTION
   - Detect when user switches tabs or minimizes
   - Show warning popup
   - After 3 violations → auto-submit exam
------------------------------------------------------------ */

let switchCount = 0;
const maxSwitchAllowed = 3;

// Create warning box
function showWarning(msg) {
    let div = document.createElement("div");
    div.style.position = "fixed";
    div.style.top = "20px";
    div.style.right = "20px";
    div.style.zIndex = "9999";
    div.style.padding = "15px 20px";
    div.style.background = "#ff4444";
    div.style.color = "#fff";
    div.style.borderRadius = "6px";
    div.style.fontSize = "16px";
    div.style.boxShadow = "0 0 10px rgba(0,0,0,0.3)";
    div.textContent = msg;

    document.body.appendChild(div);

    setTimeout(() => { div.remove(); }, 3000);
}

// Listen for tab switching / minimize
document.addEventListener("visibilitychange", function () {
    if (document.hidden) {
        switchCount++;

        showWarning("⚠ Warning: You switched tabs! (" + switchCount + "/" + maxSwitchAllowed + ")");

        if (switchCount >= maxSwitchAllowed) {
            alert("You switched tabs too many times! The exam will now be submitted.");
            document.getElementById("examForm").submit();
        }
    }
});

</script>
