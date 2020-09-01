<?php
/*  Application: Sample Input Form
 *  Script Name: index.php
 *  Description: Simple input form to colect information from the user
 *  Last Change/Update: 08/06/2020
*/

// Start session
session_start();

// Load Functions
// This is where function to connect to the database will be included

// Set script variables
$we_have_input = false;

// Handle POST data
// This is where we deal with the input from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['first'])) {
	  $first = $_POST['first'];
	} else {
	  $first = "";
  }

	if (isset($_POST['last'])) {
	  $last = $_POST['last'];
	} else {
	  $last = "";
	}

	$fullname = $first .' ' .$last;
	$we_have_input = true;

	// In this area you would:
	// Check/test/verify the user input
	// Prepare it to be written to the database
	// Write it to the database
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sample Input Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>

<?php
echo('<div class="w3-card-4">');
  if ($we_have_input) {
    echo('<div class="w3-container w3-blue">');
		echo('<h3>' .$fullname .'</h3>');

	} else {
    echo('<form method = "Post" action = test.php>');
			echo('<section class = "Text">');
				echo('<span>What type of journaling do you like?</span>');
				echo('<br>');
				echo('<input type = "text">');
				echo('<br>');
				echo('<br>');
			echo('</section>	');

			echo('<section class = "Radio">');
				echo('<span>How often do you journal?</span>');
				echo('<br>');

				echo('<input type = "radio" name = "Freq_Journal" value = " Frequently" id = "Frequently">');
				echo('<label for = "Frequently">Frequently</label>');

				echo('<input type = "radio" name = "Freq_Journal" value = " Often" id = "Often">');
				echo('<label for = "Often">Often</label>');

				echo('<input type = "radio" name = "Freq_Journal" value = " Little to none" id = "Little to none">');
				echo('<label for = "Little to none">Little to none</label>');

				echo('<br>');
				echo('<br>');
			echo('</section>');

			echo('<section class = "Checkbox">');
				echo('<span>What types of journals do you have experience with?</span>');
				echo('<br>');

				echo('<input type = "checkbox" name = "Journal Type" id = "Bullet" value = "Bullet">');
				echo('<label for = "Bullet">Bullet journaling</label>');
				echo('<br>');

				echo('<input type = "checkbox" name = "Journal Type" id = "Dream" value = "Dream">');
				echo('<label for = "Dream">Dream journaling</label>');
				echo('<br>');

				echo('<input type = "checkbox" name = "Journal Type" id = "Travel" value = "Travel">');
				echo('<label for = "Travel">Travel journaling</label>');
				echo('<br>');

				echo('<input type = "checkbox" name = "Journal Type" id = "Freeform" value = "Freeform">');
				echo('<label for = "Freeform">Freeform journaling</label>');
				echo('<br>');
				echo('<br>');
			echo('</section>');

			echo('<section class = "Number">');
				echo('<label for = "Journal number">How many journals have you done before?</label>');
				echo('<br>');

				echo('<input type = "number" name = "Journal number" id = "Journal number">');
				echo('<br>');
				echo('<br>');
			echo('</section>');

			echo('<section class = "Range">');
				echo('<label for = "Comfort level">How comfortable are you with journaling?</label>');
				echo('<br>');

				echo('<span>Super uncomfortable</span>');
				echo('<input type = "range" name = "Comfort level" id = "Comfort level"  value = "5" min = "0" max = "10" step = "1">');
				echo('<span>Super comfortable</span>');
				echo('<br>');
				echo('<br>');
			echo('</section>');

			echo('<section class = "Range2">');
				echo('<label for = "Comfort level2">How comfortable are you with journaling?</label>');
				echo('<br>');

				echo('<span>Super uncomfortable</span>');
				echo('<input type = "range" name = "Comfort level2" id = "Comfort level2"  list = "tickmarks" value = "5" min = "0" max = "10" step = "1">');

				echo('<datalist id = "tickmarks">');
					echo('<option value = "0" label = "0"></option>');
					echo('<option value = "1" label = "1"></option>');
					echo('<option value = "2" label = "2"></option>');
					echo('<option value = "3" label = "3"></option>');
					echo('<option value = "4" label = "4"></option>');
					echo('<option value = "5" label = "5"></option>');
					echo('<option value = "6" label = "6"></option>');
					echo('<option value = "7" label = "7"></option>');
					echo('<option value = "8" label = "8"></option>');
					echo('<option value = "9" label = "9"></option>');
					echo('<option value = "10" label = "10"></option>');
				echo('</datalist>');

				echo('<span>Super comfortable</span>');
				echo('<br>');
				echo('<br>');
			echo('</section>');

			echo('<section class = "Textarea">');
				echo('<label for = "Additional comments">Please list any additional comments down here:</label>');
				echo('<br>');

				echo('<textarea id = "Additional comments" name = "Additional comments" rows = "5" cols = "50" maxlength = "500" placeholder = "Insert comments here"></textarea>');
				echo('<br>');
				echo('<br>');
			echo('</section>');

			echo('<section class = "Submit">');
				echo('<input type = "submit" value = "submit">');
			echo('</section>');

		echo('</form>');
	echo('</body>');


echo('</html>');
	}
echo('</div>');
?>

</body>
</html>
