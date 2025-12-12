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
                                    <button type="submit" id="submitBtn" class="btn btn-success d-none"
        onclick="examSubmitted = true;">
    Submit Exam
</button>
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

<script>
// Prevent multiple tabs
if (sessionStorage.getItem('exam_live_lock')) {
    alert("⚠ Exam already running in another tab. This tab will be blocked.");
    window.location.href = 'student.php';
} else {
    sessionStorage.setItem('exam_live_lock', '1');
}
window.addEventListener('beforeunload', function() {
    sessionStorage.removeItem('exam_live_lock');
});

// Disable right-click & copy/paste/print
document.addEventListener('contextmenu', e => e.preventDefault());
['copy','paste','cut','beforeprint','print'].forEach(evt => {
    window.addEventListener(evt, e => e.preventDefault());
});


// Disable F12, Ctrl+Shift+I, Ctrl+U, Ctrl+S, F5, Ctrl+R
document.onkeydown = function(e) {
    if (
        e.keyCode === 123 ||                        
        (e.ctrlKey && e.shiftKey && e.key === 'I') || 
        (e.ctrlKey && e.key === 'U') ||             
        (e.ctrlKey && e.key === 'S') ||             
        e.keyCode === 116 ||                        
        (e.ctrlKey && e.key === 'R')                
    ) { e.preventDefault(); return false; }
};

// Prevent back button
history.pushState(null, null, location.href);
window.onpopstate = function() { history.go(1); };

// Detect tab switching
let switchCount = 0;
document.addEventListener("visibilitychange", function() {

    // 🔧 FIX: Do NOT show tab-switch alerts during submit
    if (examSubmitted) return;

    if (document.hidden) {
        switchCount++;
        alert("⚠ Please do not switch tabs during the exam!");
        if (switchCount >= 3) {
            alert("Exam auto-submitted due to repeated tab switching.");
            document.getElementById("examForm").submit();
        }
    }
});

// Detect DevTools
setInterval(function() {
    if (examSubmitted) return; 

    const before = new Date().getTime();
    debugger;
    const after = new Date().getTime();
    if (after - before > 100) {
        alert("⚠ DevTools detected! Exam will be auto-submitted.");
        document.getElementById("examForm").submit();
    }
}, 1000);


// Detect PrintScreen

document.addEventListener("keyup", (e) => {
    if (examSubmitted) return; // FIX
    if (e.key === "PrintScreen") alert("Screenshots are not allowed!");
});


// Disable refresh/reload (MAIN CAUSE OF POPUP)

window.onbeforeunload = function (e) {
    if (!examSubmitted) {
        e.preventDefault();
        return "Exam in progress.";
    }
};


// Question Navigation

let currentIndex = 0;
const totalQuestions = <?= count($questions); ?>;
const questionBlocks = document.querySelectorAll('.question-block');
const pageSize = 5;

function showQuestions(start) {
    questionBlocks.forEach((block, i) => block.classList.toggle('d-none', i < start || i >= start + pageSize));
    document.getElementById('currentQuestion').textContent = start + 1;
    document.getElementById('currentQuestionEnd').textContent = Math.min(start + pageSize, totalQuestions);
    document.getElementById('prevBtn').style.display = start === 0 ? 'none' : 'inline-block';
    document.getElementById('nextBtn').style.display = start + pageSize >= totalQuestions ? 'none' : 'inline-block';
    document.getElementById('submitBtn').classList.toggle('d-none', start + pageSize < totalQuestions);
}

document.getElementById('prevBtn').addEventListener('click', () => {
    if (currentIndex > 0) { currentIndex -= pageSize; if (currentIndex < 0) currentIndex = 0; showQuestions(currentIndex); }
});
document.getElementById('nextBtn').addEventListener('click', () => {
    if (currentIndex + pageSize < totalQuestions) { currentIndex += pageSize; showQuestions(currentIndex); }
});

showQuestions(currentIndex);

// UPDATED TIMER LOGIC

let examSubmitted = false;  // <--- Needed

let duration = <?= intval($exam['duration_minutes'] ?? 30); ?> * 60;
const timerEl = document.getElementById('timer');

const countdown = setInterval(() => {
    if (examSubmitted) {
        clearInterval(countdown);
        return;
    }

    const minutes = Math.floor(duration / 60);
    const seconds = duration % 60;
    timerEl.textContent = minutes + ":" + (seconds < 10 ? '0'+seconds : seconds);

    if (--duration < 0) {
        clearInterval(countdown);
        if (!examSubmitted) {
            document.getElementById("examForm").submit();
        }
    }
}, 1000);

//  MAIN FIX: Disable warnings during submit

document.getElementById("examForm").addEventListener("submit", function () {
    examSubmitted = true;

    // Disable all warnings
    window.onbeforeunload = null;

    // Prevent session lock from making popup
    sessionStorage.removeItem('exam_live_lock');
});

</script>
