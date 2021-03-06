<?php 

session_start();
include_once('../includes/fetchAttendance.php'); 
include_once("../includes/dbh.inc.php");
include_once("../includes/event.inc.php");
include_once('../team_test2.php'); 
include_once('../includes/team.inc.php');
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$uid = $_SESSION['user_id'];

$trainingHrs = new Attendance;
$trainingHrs->get_training_hours($uid);

$event = new event;
$hour_completed = $event->count_trained_hour($_SESSION['user_id']);
$team = new team;
$team->get_team_by_user($_SESSION['user_id']);
$team->get_team_by_team($team->team_id);
$team->get_team_role_code($_SESSION['user_id']);
$trc = $team->t_r_c;
$result = $team->get_team_role_code($_SESSION['user_id']);

$event = new event;
$train_events = $event->get_training();
$joined_events = $event->get_joined_event($_SESSION['user_id']);
$unjoin_events = $event->get_unjoin_event($_SESSION['user_id']);

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if(isset($_POST['join_form'])){
//         $event = new Event;
//         $event->join_event($_SESSION['user_id'],$_POST['event_id']);
//     }



// // header('Location: '.$_SERVER['REQUEST_URI']);
// }

if($result == 1) {
	$hideme = '#user {display: none;}';
}
else {
	$hideme = '';
}


?>

<style>
<?php echo $hideme ?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Participants</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="images/icon/logo2.png" alt="DELL" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
					<li class="has-sub">
                                <h3>Profile</h3>
								<br>
								<li>Username:</li>
								<li><?php echo $_SESSION['user_name']?></li>
								<li>Name:</li>
								<li><?php echo $_SESSION['user_first_name']." ".$_SESSION['user_last_name']?></li>
								<li>Gender:</li>
								<li><?php echo $_SESSION['user_gender']?></li>
								<li>Role:</li>
								<li><?php echo $_SESSION['user_role_code']?></li>
                                <li>User ID:</li>
								<li><?php echo $_SESSION['user_id']?></li>
                            </ul>
                        </li>
                            </ul>
                        </li>
                        <form action="logout.php">
                            <input type="submit" value="Logout">
                        </form>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
					
                        <div class="row">
                            <div class="col-md-12">
							<!-- TRAININGS DATA-->
                                <h2 class="title-1 m-b-25">Trainings Details</h2>
								<h6 class="title-5 m-b-25"> Hours completed : <?php echo $hour_completed?></h6>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>Trainings</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
												<th>Description</th>
												<th></th>
                                            </tr>
                                        </thead>
                                        <!-- PHP CODE TO FETCH DATA FROM ROWS
										<?php   // LOOP TILL END OF DATA  
											//while($rows=$result->fetch_assoc()) 
											//{ 
                                            foreach ($train_events as $event) {
										?> 
										END PHP-->
										<tbody>
                                            <tr>
                                                <td><?php echo $event->event_name?></td>
                                                <td><?php echo $event->event_start_date?></td>
                                                <td><?php echo $event->event_end_date?></td>
                                                <td><?php echo $event->event_status_description?></td>
												<td><?php echo $event->other_details?></td>
												<td> 
                                                <button type="button" class="btn btn-secondary mb-1">
															JOIN <!-- SCROLL DOWN TO FIND MODAL -->
													</button>
												</td>
                                            </tr>
										</tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
							<!-- END TRAININGS DATA-->
						</div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- EVENT DATA-->
                                <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                                    <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                                        <div class="bg-overlay bg-overlay--blue"></div>
                                        <h3>EVENTS</h3>
                                    </div>
                                    <div class="table-responsive table-data">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Date</td>
                                                    <td>Description</td>
													<td>Hours</td>
													<td></td>
                                                </tr>
                                            </thead>
											<!-- PHP CODE TO FETCH DATA FROM ROWS
											<?php   // LOOP TILL END OF DATA  
												$con = mysqli_connect('localhost','root','','itdp'); //EDIT DATABASE CONNECTION
												if (!$con) {
												  die('Could not connect: ' . mysqli_error($con));
												}
											?> 
											END PHP-->
                                            <tbody>
                                                                                    <!-- PHP CODE TO FETCH DATA FROM ROWS
										<?php   // LOOP TILL END OF DATA  
											//while($rows=$result->fetch_assoc()) 
											//{ 
                                            foreach ($joined_events as $event) {
										?> 
										END PHP-->
										<tbody>
                                            <tr>
                                                <td><?php echo $event->event_name?></td>
                                                <td><?php echo $event->event_start_date?></td>
                                                <td><?php echo $event->other_details?></td>
                                                <td><?php echo $event->event_status_description?></td>
												
                                            </tr>
										</tbody>
                                        <?php } ?>
											<?php
											
												// $records = mysqli_query($con,"select * from events"); // fetch data from database

												// while($data = mysqli_fetch_array($records))
												// {
                                                    foreach ($unjoin_events as $event) {
											?>
                                            <form action="join_event.php" method="POST">
                                            
                                                <tr>
                                                    <td>
                                                        <div class="table-data__info">
                                                            <h6><?php echo $event->event_name?></h6>
                                                            <input type="hidden" name="event_id" value="<?php echo $event->event_id?>">
                                                            <input type="hidden" name="join_form" value="SET">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="table-data__info">
                                                            <h6><?php echo $event->event_start_date?></h6>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="table-data__info">
                                                            <h6><?php echo $event->other_details?></h6>
                                                        </div>
                                                    </td>
													<td>
                                                        <div class="table-data__info">
                                                            <h6><?php echo $event->event_status_description?></h6>
                                                        </div>
                                                    </td>
													<td>
														<input type="submit" value ="JOIN" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#smallmodal">
															<!-- SCROLL DOWN TO FIND MODAL -->
														<!-- </input> -->
                                                    </td>
                                                </tr>
                                            </form>
											<?php 
												}
											?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="user-data__footer">
                                        <button class="au-btn au-btn-load">load more</button>
                                    </div>
                                </div>
                                <!-- END EVENT DATA-->
                            </div>
						
                            <div class="col-lg-6" id="user">
                                <!-- COMMITTEE-->
                                <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                                    <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                                        <div class="bg-overlay bg-overlay--blue"></div>
                                        <h3>COMMITTEE</h3>
                                    </div>
                                    <div class="table-responsive table-data">
										<div class="au-message__noti">
											<p>List Of Members
											</p>
										</div>
                                        <table class="table">
											<thead>
												<tr>
													<th>Name</th>
													<th>User ID</th>
													<th>User Role</th>
												</tr>
											</thead>
										
											<tbody>
											<?php
												foreach ($team->member_list as $member)
												{
											?>
                                                <tr>
                                                    <td>
                                                        <div class="table-data__info">
                                                            <h6><?php echo $member->user_first_name . " " . $member->user_last_name ?>   </h6>
                                                        </div>
                                                    </td>
													<td>
                                                        <div class="table-data__info">
                                                            <h6><?php echo $member->user_id ?></h6>
                                                        </div>
                                                    </td>
													<td>
                                                        <div class="table-data__info">
                                                            <h6><?php echo $member->team_role ?></h6>
                                                        </div>
                                                    </td>
                                                </tr>
												<?php 
												}
												?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="user-data__footer">
                                        <button class="au-btn au-btn-load">load more</button>
                                    </div>
                                </div>
                                <!-- END COMMITTEE-->
                            </div>
                            <?php
                                if($trc == 2){
                            ?>
							<div class="col-lg-6" id="user">
								<div class="card">
									<div class="card-header">
										<strong>Committee Feedback</strong>
									</div>
									<div class="card-body card-block"> 
										<form action="team_process.php" method="post" enctype="multipart/form-data" class="form-horizontal">
											<div class="row form-group">
												<div class="col col-md-3">
													<label class=" form-control-label">Choose a member</label>
                                                        <select name="user_id" id="user_id">
                                                        <?php foreach ($team->member_list as $member){ 
                                                    ?>
                                                            <option value="<?php echo $member->user_id ?>"><?php echo $member->user_first_name . " " . $member->user_last_name ?></option>
                                                        <?php }?>
                                                        </select>
                                                        <input type="hidden" name="team_id" value ="<?php echo $team->team_id?>">
												</div>
												<div class="col-12 col-md-9">
													<p class="form-control-static"><!-- add in name --></p>
												</div>
											</div>
                                            <div class="row form-group">
												<div class="col col-md-3">
													<label class=" form-control-label">Choose a member</label>
                                                        <select name="event_id" id="event_id">
                                                        <?php 
                                                        $joined_events = $event->get_joined_event($_SESSION['user_id']);
                                                        foreach ($joined_events as $event) {
                                                    ?>  
                                                            <option value="<?php echo $event->event_id ?>"><?php echo $event->event_name ?></option>
                                                        <?php }?>
                                                        </select>
                                                        <input type="hidden" name="team_id" value ="<?php echo $team->team_id?>">
												</div>
												<div class="col-12 col-md-9">
													<p class="form-control-static"><!-- add in name --></p>
												</div>
											</div>
											<div class="row form-group">
												<div class="col col-md-3">
													<label for="textarea-input" class=" form-control-label">Feedback</label>
												</div>
												<div class="col-12 col-md-9">
													<textarea name="feedback" id="textarea-input" rows="9" placeholder="Content..." class="form-control"></textarea>
												</div>
											</div>
										</form>
									</div>
									<div class="card-footer">
										<button type="submit" onclick="submit()"class="btn btn-primary btn-sm">
											<i class="fa fa-dot-circle-o"></i> Submit
										</button>
										<button type="reset" class="btn btn-danger btn-sm">
											<i class="fa fa-ban"></i> Reset
										</button>
									</div>
								</div>
							</div>
                        </div>
                        <?php
                                }
                        ?>
						
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
				
			<!-- modal small -->
			<div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="smallmodalLabel"><!-- add in eventName --></h5>
						</div>
						<div class="modal-body">
							<p>
								Would you like to join this event?
							</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary">Confirm</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end modal small -->
				
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->
