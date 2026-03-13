<?php
// /templates/questions/upload_questions.php
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

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">
                <?= $results['pageTitle'] ?? 'Upload Questions CSV' ?>
            </h1>

            <!-- Success Message -->
            <?php if(!empty($results['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($results['message']) ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Error Report -->
            <?php if(!empty($results['errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Upload Errors:</strong>
                    <ul class="mb-0">
                        <?php foreach($results['errors'] as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>


            <!-- Upload Card -->
            <div class="card shadow mb-4">

                <div class="card-body">

                    <!-- CSV Upload Form -->
                    <form method="POST" enctype="multipart/form-data">

                        <div class="form-group mb-3">
                            <label>Select CSV File</label>
                            <input type="file" name="csv_file" class="form-control" required>
                        </div>

                        <button type="submit" name="preview_csv" class="btn btn-primary">
                            Preview Questions
                        </button>

                    </form>

                </div>
            </div>


            <!-- Preview Questions -->
            <?php if(!empty($_SESSION['csv_questions'])): ?>

            <div class="card shadow mb-4">

                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">
                        Preview Questions
                    </h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>
                            <tr>
                                <th>Question</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>Correct</th>
                                <th>Marks</th>
                                <th>Difficulty</th>
                                <th>Subject</th>
                                <th>Bank</th>
                            </tr>
                            </thead>

                            <tbody>

                            <?php foreach($_SESSION['csv_questions'] as $row): ?>

                            <tr>
                                <td><?= htmlspecialchars($row['question_text'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['a'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['b'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['c'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['d'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['correct'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['marks'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['difficulty'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['subject'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['bank'] ?? '') ?></td>
                            </tr>

                            <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                    <!-- Upload to Database -->
                    <form method="POST">
                        <button class="btn btn-success" name="insert_questions">
                            Upload to Database
                        </button>
                    </form>

                </div>

            </div>

            <?php endif; ?>

        </div>

    </div>

    <!-- Footer -->
    <?php include __DIR__ . "/../include/footer.php"; ?>

</div>

</div>
