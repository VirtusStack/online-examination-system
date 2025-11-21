<?php
// /templates/question_banks/edit_bank.php
// -------------------------
// View file: Displays Edit Bank
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

                <!-- Page Title -->
                <h1 class="h3 mb-4 text-gray-800">
                    <?= isset($results['pageTitle']) ? $results['pageTitle'] : 'Edit Bank' ?>
                </h1>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> 
                         alert-dismissible fade show" role="alert">
                         
                        <?= (stripos($results['message'], 'success') !== false) 
                                ? '<i class="fas fa-check-circle"></i>'  
                                : '<i class="fas fa-times-circle"></i>' ?>

                        <?= htmlspecialchars($results['message']) ?>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Edit Bank Form -->
                <div class="card shadow mb-4">
                    <div class="card-body">

                        <form method="POST"
                              action="<?= BASE_URL ?>/admin.php?action=editBank&id=<?= htmlspecialchars($results['bank']['bank_id']) ?>">

                            <!-- Bank Name -->
                            <div class="form-group mb-3">
                                <label>Bank Name:</label>
                                <input type="text" name="bank_name" class="form-control" required
                                       value="<?= htmlspecialchars($results['bank']['bank_name'] ?? '') ?>">
                            </div>

                            <!-- Description -->
                            <div class="form-group mb-3">
                                <label>Description:</label>
                                <textarea name="description" class="form-control" rows="3">
                                    <?= htmlspecialchars($results['bank']['description'] ?? '') ?>
                                </textarea>
                            </div>

                            <!-- Buttons -->
                            <button type="submit" class="btn btn-primary">Update Bank</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageBanks" class="btn btn-secondary">Cancel</a>

                        </form>

                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>

    </div>
</div>
