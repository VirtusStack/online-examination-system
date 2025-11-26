<?php include __DIR__ . "/../include/header.php"; ?>
<div id="wrapper">
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800"><?= $results['pageTitle'] ?? 'Generate Exam Links' ?></h1>

                <!-- Feedback -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= stripos($results['message'], 'success')!==false ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Show link after generation -->
                <?php if (!empty($results['unique_link_url'])): ?>
                    <div class="alert alert-success">
                        Link generated: <a href="<?= $results['unique_link_url'] ?>" target="_blank"><?= $results['unique_link_url'] ?></a>
                    </div>
                <?php endif; ?>

                <!-- Generate Link Form -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="">
                            <!-- Exam Dropdown (if no exam selected) -->
                            <div class="form-group mb-3">
                                <label>Exam:</label>
                                <select name="exam_id" class="form-control" required>
                                    <option value="">-- Select Exam --</option>
                                    <?php foreach ($results['exams'] as $exam): ?>
                                        <option value="<?= $exam['exam_id'] ?>" <?= !empty($results['exam']) && $results['exam']['exam_id']==$exam['exam_id']?'selected':'' ?>>
                                            <?= htmlspecialchars($exam['exam_title']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Student Name (optional) -->
                            <div class="form-group mb-3">
                                <label>Student Name:</label>
                                <input type="text" name="student_name" class="form-control">
                            </div>

                            <!-- Student Email -->
                            <div class="form-group mb-3">
                                <label>Student Email:</label>
                                <input type="email" name="student_email" class="form-control">
                            </div>

                            <!-- Student Class -->
                            <div class="form-group mb-3">
                                <label>Class / Standard:</label>
                                <input type="text" name="student_class" class="form-control">
                            </div>

                            <!-- Password (optional) -->
                            <div class="form-group mb-3">
                                <label>Password (optional):</label>
                                <input type="text" name="password" class="form-control">
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

                <!-- Existing Links Table -->
                <?php if (!empty($results['links'])): ?>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5>Existing Links:</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Link</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Class</th>
                                        <th>Expiry</th>
                                        <th>Used</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results['links'] as $link): ?>
                                        <tr>
                                            <td><a href="<?= BASE_URL ?>/student_panel.php?link=<?= $link['unique_link'] ?>" target="_blank"><?= $link['unique_link'] ?></a></td>
                                            <td><?= htmlspecialchars($link['student_name']) ?></td>
                                            <td><?= htmlspecialchars($link['student_email']) ?></td>
                                            <td><?= htmlspecialchars($link['student_class']) ?></td>
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
        </div>
        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>
