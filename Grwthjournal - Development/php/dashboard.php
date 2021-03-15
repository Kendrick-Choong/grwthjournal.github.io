<?php
/*  Application: Dashboard
*  Script Name: dashboard.php
*  Description: This script is the dashboard where the user will be able to see their stats and old entries as well as selecting new prompts for users to fill out.
*  Last Change/Update: 3/9/2021
*  Author: Kenny Choong
*/
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true){
    header("location: login.php");
    exit;
}

require_once "configInsertUser.php";

$link = mysqli_connect($db_server,$db_username,$db_password,$db_name);

$user_id = "";
$data_day = $data_week = $data_month = $data_year = "";
$new_array = array();

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //Set the user id
    $user_id = $_SESSION["user_id"];

    //Create an SQL statement array
    $interval1 = "TIMESTAMPDIFF(DAY,grwth_prompt.submitted_at, CURRENT_DATE) <= 7";
    $group1 = "'%d'";

    $interval2 = "TIMESTAMPDIFF(WEEK,grwth_prompt.submitted_at, CURRENT_DATE) <= 4";
    $group2 = "'%U'";

    $interval3 =  "TIMESTAMPDIFF(MONTH,grwth_prompt.submitted_at, CURRENT_DATE) <= 7";
    $group3 = "'%m'";

    $interval4 = "TIMESTAMPDIFF(YEAR,grwth_prompt.submitted_at, CURRENT_DATE) <= 7";
    $group4 = "'%Y'";

    $intervals = array(
      array($interval1,$group1),
      array($interval2,$group2),
      array($interval3,$group3),
      array($interval4,$group4));

		// Remember to add LIMIT 3;


    foreach($intervals as $interval){
        $x = implode(array_slice($interval,0,1));
        $y = implode(array_slice($interval,1,1));
        $sql = "SELECT grwth_prompt.submitted_at, grwth_prompt.entry_id, AVG(grwth_prompt.sentiment_value)
                    FROM ebdb.grwth_prompt
                    INNER JOIN grwth_login
                    ON grwth_prompt.user_id = grwth_login.user_id
                    WHERE grwth_login.user_id = ? and $x
                    GROUP BY DATE_FORMAT(grwth_prompt.submitted_at, $y)
                    ORDER BY grwth_prompt.submitted_at DESC
        						";

    		//Prepare the link and the sql, if they don't work, throw an error.
        if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_user_id);

            // Set parameters
            $param_user_id = $user_id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

              // Store result
              mysqli_stmt_bind_result($stmt, $col1, $col2, $col3);

              $data = "";

              while(mysqli_stmt_fetch($stmt)){
                $col1 = date_create($col1);
                $data .= "{x: '".date_format($col1,"m/d/Y")."', y: ".$col3."}, ";
              }

              $new_array[] = $data;

            } else {
              echo "0 results";
            }
        // Close statement
        mysqli_stmt_close($stmt);

      } else {
        echo "The mysqli_prepare didn't work";
      }
    }


  $data_day .= "[" . implode(array_slice($new_array,0,1)) . "]";
  $data_week .= "[" . implode(array_slice($new_array,1,1)) . "]";
  $data_month .= "[" . implode(array_slice($new_array,2,1)) . "]";
  $data_year .= "[" . implode(array_slice($new_array,3,1)) . "]";

} else {
  echo "The if SERVER_REQUEST statement failed";
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="The Grwth Privacy Policy" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="./../assets/css/main.css" />
		<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
	</head>
	<body class="is-preload">

		<!-- Header -->
		<header id="header">
			<nav>
				<a href="#menu" id="menuButt"></a>
			</nav>
		</header>

		<!-- Nav -->
		<nav id="menu">
			<ul class="links">
				<li><a href="./../index.html">Home</a></li>
				<li><a href="./../about.html">About</a></li>
				<li><a href="feedback.php">Provide Feedback</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>

		<!-- Heading -->
		<div id="heading">
		</div>

		<!-- Main -->
		<section id="main" class="wrapper">
			<div class="inner">
				<div class="content">
					<section id="dashname">
						<img src="./../media/images/Mike.jpg" alt="Mike Liang" id="dashImage">
					</section>
					<h2 style="text-align: center;"><?php if(empty($_SESSION["preferred_name"])){
                        echo "Your";
                      } else {
                        echo htmlspecialchars($_SESSION["preferred_name"])."'s";
                      } ?> Dashboard</h2>
					<section>

						<!-- Graph Section -->

						<h3 class="statsHead">Your Stats For the Week</h3>

						<section class="graph">


							<section class="graphFilter">

								<!-- For filtering, we need to take into account how formatting requires different database returns/ parsing -->
								<button id="dayButton" type="button" onclick="graphFilter(1);">Day</button>
								<button id="weekButton" type="button" onclick="graphFilter(2);">Week</button>
								<button id="monthButton" type="button" onclick="graphFilter(3);">Month</button>
								<button id="yearButton" type="button" onclick="graphFilter(4);">Year</button>

								<!-- Eventually a specific date filter will go here.
									This will consist of a form, where the inputs are two text boxes,
									and the submit goes into a php query which returns a day version of the graph with new data from the database -->
							</section>

							<!-- Where the graph element is located. This gets destroyed and remade each time a new graph is loaded -->
							<section id = "graphParent">
								<canvas id="canvas"></canvas>
							</section>

							<!-- Button links to the radar graphs -->
							<button id="rightButton" type="button" onclick="">Insights & Analytics</button>

						</section>

					</section>


					<!--New entry section-->
					<section class="subHeader accordian">
						<p>New Entry</p>
					</section>
					<div class="panel">
						<section class="newEntries" id="L">
							<p id="whyPrompt">"What is the number one thing that bothers you right now & why?"</p>
							<a href="./../index.html" class="logo icon fa-pencil" id="writeNowIn"> Write now</a>
						</section>
						<a href="./../index.html" class="logo icon fa-pencil" id="writeNowOut"> Write now</a>


						<!--Why Prompt Information-->
						<div id="whyP" class="whyPrompt">

							<!-- Modal content -->
							<div class="whyPrompt-content">
								<span class="closeWhy">&times;</span>
								<p>It seems like you havn't been feeling like yourself</p>
							</div>

						</div>



						<section class="newEntries" id="R">
							<p>Free Write <br>
							<em>A blank slate for you to write whatever's on your mind.</em></p>
							<a href="./../index.html" class="logo icon fa-pencil" id="writeNowIn"> Write now</a>
						</section>
						<a href="./../index.html" class="logo icon fa-pencil" id="writeNowOut"> Write now</a>
						<!--New Ideas Button-->
						<section id="ibutton">
							<button id="ideaButton" type="button" onclick="" class="logo icon fa-lightbulb-o">More Ideas</button>
						</section>

					</div>

					<!--Old Entries Section-->
					<section class="oldEntriesBox">
						<section class="subHeaderO accordian">
							<p>Previous Entries</p>
						</section>
						<div class="panel">

<!-- Start of the journal entry population portion -->
<?php

$prompt_response = "";
$prompt_title = "";
$counter = 0;
$style = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //Create an SQL statement
    $sql = "SELECT grwth_prompt.prompt_title, grwth_prompt.prompt_response, grwth_prompt.submitted_at, grwth_prompt.entry_id
            FROM grwth_prompt
            INNER JOIN grwth_login
            ON grwth_prompt.user_id = grwth_login.user_id
            WHERE grwth_login.user_id = ?
            ORDER BY grwth_prompt.submitted_at DESC
            LIMIT 0,4
            ";

    //Prepare the link and the sql, if they don't work, throw an error.
    if($stmt = mysqli_prepare($link, $sql)){

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_user_id);

        // Set parameters
        $param_user_id = $user_id;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){

          // Store result
          mysqli_stmt_bind_result($stmt, $col1, $col2, $col3,$col4);

          echo
          "<section id='oldPrompts'>";

          while(mysqli_stmt_fetch($stmt)){
            $col3 = date_create($col3);
            $counter++;
            if ($counter % 2 == 1){
              $style = "L";
            } else {
              $style = "R";
            }
            echo
            "<section class='oldEntries' id=".$style.">
              <!-- <img src='./../media/images/TreeBook.jpg'> -->
              <h3>".$col1."</h1>
              <p>".$col2."</p>
              <h4>".date_format($col3, "F d, Y")."</h4>
              <button type='button' id=".$col4." class='Edit'>Edit</button>
            </section>";
          }

        } else {
          echo "0 results";
        }

    // Close statement
    mysqli_stmt_close($stmt);

  } else {
    echo "It didn't work.";
  }
} else {
  echo "It's not working";
}
?>
            </section>
            <button type='button' class='promptRefreshMinus4' id='promptRefreshMinus4'> Load Less Entries</button>
            <button type='button' class='promptRefreshPlus4' id='promptRefreshPlus4'> Load More Entries</button>
            </div>
          </section>
        </section>


		<!-- Footer -->
		<footer id="footer">
			<div class="inner">
				<div class="content">
					<section>
					<!-- <li><a href="#"><i class="icon fa-github">&nbsp;</i>Github</a></li> -->
						<h3>Follow Our Journey</h3>
						<ul class="plain">
							<li><a href="#"><i class="icon fa-twitter">&nbsp;</i>Twitter</a></li>
							<li><a href="#"><i class="icon fa-facebook">&nbsp;</i>Facebook</a></li>
							<li><a href="#"><i class="icon fa-instagram">&nbsp;</i>Instagram</a></li>
						</ul>
					</section>

					<section>
						<h3>Navigation</h3>
						<ul class="plain">
							<li><a href="./../about.html">About</a></li>
							<li><a href="signup.php">Sign Up</a></li>
							<li><a href="./../privacypolicy.html">Privacy Policy</a></li>
						</ul>
					</section>

					<section>
						<h3>Your Privacy is Our Concern</h3>
						<p>At Grwth, no human will <em>ever</em> see or use your individual data, and the machines will only use it (with your permission) to create custom repsonses for your benefit. If opted in, your data will be aggregated with thousands of other peoples to see large scale trends in population segments.</p>
					</section>

				</div>
				<div class="copyright">
					&copy; grwthLLC
				</div>
			</div>
		</footer>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>

		<!-- Scripts for chart.js -->
		<script src="assets/js/Chart.js-2.9.4/dist/Moment.js"></script>
		<script src="assets/js/Chart.js-2.9.4/dist/Chart.js"></script>
		<script src="assets/js/Chart.js-2.9.4/dist/Chart.min.js"></script>

		<!-- Graph Script -->


		<script>

			function loadMore(curr, next){
				document.getElementById(curr).style.display = "none";
				document.getElementById(next).style.display = "block";
			}


				var unit = 'day'
				var data = <?php echo "[{
							x: '01/17/2021', y: 5
						}, {
							x: '01/18/2021', y: 5
						}, {
							x: '01/19/2021', y: 5
						}, {
							x: '01/20/2021', y: 5
						}, {
							x: '01/21/2021', y: 5
						}, {
							x: '01/22/2021', y: 5
						}, {
							x: '01/23/2021', y: 5
						}]";?>

				var config = {
					type:    'line',
					data:    {
						datasets: [
							{
								label: "Overall Entry Sentiment",
								lineTension: 0,
								pointRadius: 7,
								hitRadius: 10,
								hoverRadius: 5,
								pointBackgroundColor: 'rgba(255, 255, 255, 1)',
								data: data,
								fill: false,
								borderColor: 'rgba(255,100,200,1)'
							}
						]
					},
					options: {
						bezierCurve: false,
						responsive: true,
						legend:{
							display: false
						},
						title:      {
							display: false,
							text:    "Your Stats For the Week"
						},
						scales:     {
							xAxes: [{
								type:       "time",
								time:       {
									unit: unit,
									displayFormats:{
										day: 'MMM Do',
										week: 'MMM Do',
										month: 'MMM YY',
										year: 'YYYY'
									}
								},
								fontstyle: 'bold',
								scaleLabel: {
									display:     false,
									labelString: 'Date'
								},
								gridLines: {
								color: "rgba(0, 0, 0, 0)",
								},
								ticks:{
									fontSize: 14,
									padding: 0,
									fontColor: '#000'
								}
							}],
							yAxes: [{
								scaleLabel: {
									display:     false,
									labelString: 'value'
								},
								gridLines: {
								color: "rgba(0, 0, 0, 0)",
								},
								ticks:{
									max: 10,
									min: 0,
									fontSize: 16,
									padding: 0,
									fontColor: '#000'
								}
							}]
						}
					}
				};

				// Getting points at a clicked location, can be used to make pop ups based upon associated data
				// canvas.onclick = function (evt) {
				//     var points = chart.getPointsAtEvent(evt);
				//     alert(chart.datasets[0].points.indexOf(points[0]));
				// };

			function removeElement(elementId) {
				// Removes an element from the document
				var element = document.getElementById(elementId);
				element.parentNode.removeChild(element);
			}

			function addElement(parentId, elementTag, elementId, html) {
				// Adds an element to the document
				var p = document.getElementById(parentId);
				var newElement = document.createElement(elementTag);
				newElement.setAttribute('id', elementId);
				newElement.innerHTML = html;
				p.appendChild(newElement);
			}

			//Filters the graph to display different data
			function graphFilter(x){

        if (screen.width < 496){
						config.data.datasets[0].pointRadius = 4;
						config.data.datasets[0].hitRadius = 5;
						config.data.datasets[0].hoverRadius = 5;

						config.options.scales.xAxes[0].ticks.fontSize = 10;
						config.options.scales.yAxes[0].ticks.fontSize = 10;

					}else{
						config.data.datasets[0].pointRadius = 7;
						config.data.datasets[0].hitRadius = 10;
						config.data.datasets[0].hoverRadius = 5;

						config.options.scales.xAxes[0].ticks.fontSize = 16;
						config.options.scales.yAxes[0].ticks.fontSize = 14;
					}

				if (x == 1){
					document.getElementById("dayButton").style.color = "black";
					document.getElementById("weekButton").style.color = "gray";
					document.getElementById("monthButton").style.color = "gray";
					document.getElementById("yearButton").style.color = "gray";

					unit = 'day'
					data = <?php echo $data_day; ?>

					config.data.datasets[0].data = data;
					config.options.scales.xAxes[0].time.unit = unit;

					removeElement("canvas");
					addElement("graphParent", "canvas", "canvas", "");


				}
				else if (x == 2){
					document.getElementById("dayButton").style.color = "gray";
					document.getElementById("weekButton").style.color = "black";
					document.getElementById("monthButton").style.color = "gray";
					document.getElementById("yearButton").style.color = "gray";

					unit = 'week'

					data = <?php echo $data_week; ?>

					config.data.datasets[0].data = data;
					config.options.scales.xAxes[0].time.unit = unit;

					removeElement("canvas");
					addElement("graphParent", "canvas", "canvas", "");

				}
				else if (x == 3){
					document.getElementById("dayButton").style.color = "gray";
					document.getElementById("weekButton").style.color = "gray";
					document.getElementById("monthButton").style.color = "black";
					document.getElementById("yearButton").style.color = "gray";

					unit = 'month'

					data =
						<?php echo $data_month;?>

					config.data.datasets[0].data = data;
					config.options.scales.xAxes[0].time.unit = unit;

					removeElement("canvas");
					addElement("graphParent", "canvas", "canvas", "");

				}
				else{
					document.getElementById("dayButton").style.color = "gray";
					document.getElementById("weekButton").style.color = "gray";
					document.getElementById("monthButton").style.color = "gray";
					document.getElementById("yearButton").style.color = "black";

					unit = 'year'

					data = <?php echo $data_year; ?>

					config.data.datasets[0].data = data;
					config.options.scales.xAxes[0].time.unit = unit;

					removeElement("canvas");
					addElement("graphParent", "canvas", "canvas", "");


				}
				var ctx       = document.getElementById("canvas").getContext("2d");
				window.myLine = new Chart(ctx, config);
			};

			window.onload = function () {
				graphFilter(1)
			};
			</script>

      <script type="text/javascript">
        $(".Edit").click(function () {
            location.href = "promptEdit.php?entry_id="+this.id;
        });
      </script>

      <script type="text/javascript">
        var limitCountStart = 0;
        $(document).ready(function() {
            if (limitCountStart==0){
              document.getElementById("promptRefreshMinus4").style.display = "none";
            } else {
              document.getElementById("promptRefreshMinus4").style.display = "block";
            }
            $(".promptRefreshPlus4").click(function() {
              limitCountStart = limitCountStart + 4;
              if (limitCountStart==0){
                document.getElementById("promptRefreshMinus4").style.display = "none";
              } else {
                document.getElementById("promptRefreshMinus4").style.display = "block";
              }
              $('#oldPrompts').load("dashboardRefresh.php", {
                  newLimitCountStart: limitCountStart
              });
            });
        });
        $(document).ready(function() {
            $(".promptRefreshMinus4").click(function() {
              if (limitCountStart == 4){
                document.getElementById("promptRefreshMinus4").style.display = "none";
              } else {
                document.getElementById("promptRefreshMinus4").style.display = "block";
              }
              limitCountStart = limitCountStart - 4;
              $('#oldPrompts').load("dashboardRefresh.php", {
                  newLimitCountStart: limitCountStart
              });
            });
        });
      </script>

      <script>
				var acc = document.getElementsByClassName("accordian");
				var i;

				for (i = 0; i < acc.length; i++) {
				  acc[i].addEventListener("click", function() {
					this.classList.toggle("active");
					var panel = this.nextElementSibling;
					if (panel.style.maxHeight) {
					  panel.style.maxHeight = null;
					} else {
					  panel.style.maxHeight = panel.scrollHeight + "px";
					}
				  });
				}
			</script>
	</body>
</html>
