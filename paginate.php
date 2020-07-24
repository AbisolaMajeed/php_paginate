<?php

	$db = mysqli_connect("localhost", "root", "", "student") or die(mysqli_connect_error());

	//	Number of records to show per page;
	$display = 10;

	//	Determine how many pages there are...
	if(isset($_GET['P']) && is_numeric($_GET['p'])) {
		//	Already been determined.
		$pages = $_GET['P'];
	} else {	// Need to determine.
		//	Count the number of records:

		$q = "SELECT COUNT(id) FROM employee";

		$r = mysqli_query($db, $q);
		$row = mysqli_fetch_array($r);
		$records = $row[0];

		//echo $records;

		// 	Calculate the number of pages...

		if($records > $display){	//more than one page
			$pages = ceil($records/$display);

			//echo $pages;
		} else {
			$pages = 1;
		}
	} // End of p IF.

	//	Determine where inthe database to start returning results...
	if (isset($_GET['s']) && is_numeric ($_GET['s'])) {
		$start = $_GET['s'];
	} else {
		$start = 0;
	}

	//	Define the query:

	$q = "SELECT * FROM employee LIMIT 		$start, $display";

	$r = mysqli_query($db, 	$q) or die(mysqli_error($db));




	//	Table header:

	echo 	'<table align="center" 	cellspacing="0" cellpadding="5" width="75%">
		<tr>
			<td align="left"><b>Firstname</b></td>
			<td align="left"><b>Lastname</b></td>
			<td align="left"><b>Salary</b></td>
			<td align="left"><b>Commission</b></td>
		</tr>';

		//Fetch and print all the records...

		$bg = '#eeeeee'; // Set the initial background color.

		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			$bg = ( $bg == '#eeeeee' ? '#fffffff' : '#eeeeee'); // Switch the background color

			echo '<tr bgcolor = "'.$bg.'">
					<td align="left"><b>'.$row['firstName'].'</b></td>
					<td align="left"><b>'.$row['lastName'].'</b></td>
					<td align="left"><b>'.$row['salary'].'</b></td>
					<td align="left"><b>'.$row['commission'].'</b></td>
				</tr>';
		} //END WHILE LOOP

		echo '</table';

		mysqli_free_result ($r);
		mysqli_close($db);

		// Make the links to other pages, if necessary.

		if($pages > 1) {

			// Add some spacing and start a paragraph:
			echo '<br/><p>';
			// Determine what the page the script is
			$current_page = ($start/$display) + 1;

			// If it's not the first page, make a Previous link:
			if ($current_page !=1) {
				echo '<a href="paginate.php?s='.($start - $display).'&p='.$pages.'">Previous</a>';
			}

			// Make all the numbered pages:
			for ($i = 1; $i <= $pages; $i++) {
				if ($i !=$current_page) {
					echo '<a href="paginate.php?s='.(($display+ ($i - 1))).'&p='.$pages.'">'.$i.'</a>';
				} else{
					echo $i .' ';
				}
			} // End of FOR loop.

			// If it's not the last page, make a Next button:
			if ($current_page != $pages) {
				echo '<a href="paginate.php?s=' .($start + $display).'&p='.$pages .'">Next</a>';
			}
			echo '</p>'; // Close the paragraph.

		} // End of links section











?>