<?php
// /templates/students/add_student.php
require_once __DIR__ . '/../../config/config.php';
?>
<?php include __DIR__ . "/../include/header.php"; ?>

<div id="wrapper">
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">
                    <?= $results['pageTitle'] ?? 'Add Student' ?>
                </h1>

                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= (stripos($results['message'], 'success') !== false)  ? '<i class="fas fa-check-circle"></i>'  : '<i class="fas fa-times-circle"></i>' ?>
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=newStudent">

                            <div class="form-group mb-3">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" required
                                    value="<?= htmlspecialchars($results['name'] ?? '') ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control" required
                                    value="<?= htmlspecialchars($results['email'] ?? '') ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Password:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Roll No:</label>
                                <input type="text" name="roll_no" class="form-control"
                                    value="<?= htmlspecialchars($results['roll_no'] ?? '') ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Class:</label>
                                <select name="class_id" class="form-control" required>
                                    <option value="">Select Class</option>
                                    <?php foreach ($results['classes'] as $cls): ?>
                                        <option value="<?= $cls['class_id'] ?>" <?= (isset($results['class_id']) && $results['class_id']==$cls['class_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cls['class_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Section:</label>
                                <input type="text" name="section" class="form-control" value="<?= htmlspecialchars($results['section'] ?? '') ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Phone:</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($results['phone'] ?? '') ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>Status:</label>
                                <select name="status" class="form-control">
                                    <option value="Active" <?= (isset($results['status']) && $results['status']=='Active') ? 'selected' : '' ?>>Active</option>
                                    <option value="Inactive" <?= (isset($results['status']) && $results['status']=='Inactive') ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>
