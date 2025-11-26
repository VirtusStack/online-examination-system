<?php
// /templates/exams/generate_links.php
// -------------------------
// Admin panel: Generate unique exam links for students
require_once __DIR__ . '/../../config/config.php';

$exams = $results['exams'] ?? [];
$examId = isset($results['exam']['exam_id']) ? $results['exam']['exam_id'] : null;
$links = $results['links'] ?? [];
$message = $results['message'] ?? '';
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

                <h1 class="h3 mb-4 text-gray-800"><?= $results['pageTitle'] ?? 'Generate Exam Links' ?></h1>

                <!-- Feedback message -->
                <?php if (!empty($message)): ?>
                    <div class="alert <?= (stripos($message, 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Generate Link Form -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=generateLinks">

                            <!-- Select Exam -->
                            <div class="form-group mb-3">
                                <label>Select Exam:</label>
                                <select name="exam_id" class="form-control" required>
                                    <option value="">-- Select Exam --</option>
                                    <?php foreach ($exams as $exam): ?>
                                        <option value="<?= $exam['exam_id'] ?>" <?= ($examId == $exam['exam_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($exam['exam_title']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Student Name (optional) -->
                            <div class="form-group mb-3">
                                <label>Student Name (optional):</label>
                                <input type="text" name="student_name" class="form-control" value="">
                            </div>

                            <!-- Student Email (optional) -->
                            <div class="form-group mb-3">
                                <label>Student Email (optional):</label>
                                <input type="email" name="student_email" class="form-control" value="">
                            </div>

                            <!-- Student Class (optional) -->
                            <div class="form-group mb-3">
                                <label>Class / Standard (optional):</label>
                                <input type="text" name="student_class" class="form-control" value="">
                            </div>

                            <!-- Password (optional) -->
                            <div class="form-group mb-3">
                                <label>Password (optional):</label>
                                <input type="text" name="password" class="form-control" value="">
                            </div>

                            <!-- Expiry -->
                            <div class="form-group mb-3">
                                <label>Link Expiry:</label>
                                <input type="date" name="expires_at" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Generate Link</button>
                        </form>
                    </div>
                </div>

                <!-- Display Generated Links -->
                <?php if (!empty($links)): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            Generated Links
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Student Email</th>
                                        <th>Class</th>
                                        <th>Unique Link</th>
                                        <th>Expiry</th>
                                        <th>Used</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($links as $link): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($link['student_name']) ?></td>
                                            <td><?= htmlspecialchars($link['student_email']) ?></td>
                                            <td><?= htmlspecialchars($link['student_class']) ?></td>
                                            <td><a href="<?= BASE_URL ?>/student.php?link=<?= $link['unique_link'] ?>" target="_blank"><?= $link['unique_link'] ?></a></td>
                                            <td><?= $link['expires_at'] ?></td>
                                            <td><?= $link['is_used'] ? 'Yes' : 'No' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

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
