<?php
// /templates/common/index.php
// ---------------------------
// Admin Dashboard for Online Examination System

// Make sure session is started in admin.php
$adminName = $_SESSION['admin_name'] ?? 'Unknown';
?>
 <?php include __DIR__ . '/../include/header.php'; ?>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include __DIR__ . '/../include/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include __DIR__ . '/../include/navbar.php'; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                </div>

                <!-- Content Row -->
		<div class="row">

    		<!-- Total Exams -->
    		<div class="col-xl-3 col-md-6 mb-4">
        	<div class="card border-left-primary shadow h-100 py-2">
            	     <div class="card-body">
                         <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    		Total Exams
                	</div>
                   	 <div class="h5 mb-0 font-weight-bold text-gray-800">
                    		<?= (int)$results['totalExams'] ?>
                	 </div>
            	       </div>
       		    </div>
    		</div>

    		<!-- Active Exams -->
    		<div class="col-xl-3 col-md-6 mb-4">
        	     <div class="card border-left-success shadow h-100 py-2">
            		  <div class="card-body">
                	      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    		  Active Exams
                              </div>
                	   <div class="h5 mb-0 font-weight-bold text-gray-800">
                    		<?= (int)$results['activeExams'] ?>
               		   </div>
            	       </div>
        	   </div>
    	       </div>

    		<!-- Question Banks -->
    		<div class="col-xl-3 col-md-6 mb-4">
        	     <div class="card border-left-info shadow h-100 py-2">
                         <div class="card-body">
                              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    		   Question Banks
                	      </div>
                	    <div class="h5 mb-0 font-weight-bold text-gray-800">
                    		<?= (int)$results['totalBanks'] ?>
                	    </div>
            		</div>
        	   </div>
    	      </div>

   	      <!-- Questions -->
    	      <div class="col-xl-3 col-md-6 mb-4">
        	   <div class="card border-left-warning shadow h-100 py-2">
            		<div class="card-body">
                	   <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    		 Total Questions
                	   </div>
                	   <div class="h5 mb-0 font-weight-bold text-gray-800">
                    	     <?= (int)$results['totalQuestions'] ?>
                	   </div>
            	         </div>
        	      </div>
   		 </div>
             </div>

	     <div class="row">

    	     <!-- Students -->
    	     <div class="col-xl-6 col-md-6 mb-4">
        	  <div class="card border-left-secondary shadow h-100 py-2">
            		<div class="card-body">
                	    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                   		 Registered Students
                	   </div>
                	  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    		<?= (int)$results['totalStudents'] ?>
                	  </div>
            	      </div>
        	</div>
    	   </div>

    	   <!-- Results -->
    	   <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-dark shadow h-100 py-2">
            	     <div class="card-body">
                	  <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                    		Submitted Results
                	 </div>
                         <div class="h5 mb-0 font-weight-bold text-gray-800">
                    	 <?= (int)$results['totalResults'] ?>
                       </div>
            	   </div>
               </div>
          </div>

                </div> <!-- End Row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include __DIR__ . '/../include/footer.php'; ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
