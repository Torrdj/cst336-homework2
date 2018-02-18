<html>
	<head>
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
	</head>
	<header>
		<table>
			<tr>
				<td><img src="img/interrogation.png" id="img"/></td>
				<td id="title">Mystery Number</td>
				<td><img src="img/interrogation.png" id="img"/></td>
			</tr>
		</table>
	</header>
	<body>
		<hr/>
		<?php
			function bubble_sort($array)
			{
				$i = 1;
				while ($i < sizeof($array))
				{
					$j = $i;
					while ($j > 0 && $array[$j-1][1] > $array[$j][1])
					{
						//Swap j and j-1
						$temp = $array[$j];
						$array[$j] = $array[$j-1];
						$array[$j-1] = $temp;

						$j--;
					}
					$i++;
				}
				return $array;
			}
			
			if ($_POST)
			{
				$mystery = $_POST['mystery'];
				$scores = $_POST['scores'];
				echo "<form method='post'>
						<input type='hidden' name='mystery' value=$mystery />";
				if ($_POST['number'])
				{
					$turn = ($_POST['turn']) + 1;
					$number = $_POST['number'];
					if ($number != $mystery)
					{
						echo ($number < $mystery ? 
								"More"
								: "Less")."<br/>";
						echo "Try again: <input type='number' name='number' autofocus />
							<input type='hidden' name='turn' value=$turn />
							<input type='hidden' name='scores' value=$scores />
							<input type='submit' value='Submit' />";
					}
					else
					{
						echo "Congratulation !!!<br/>";
						$scores = unserialize($scores);
						if (!is_array($scores))
							$scores = array();
						if (sizeof($scores) > 9)
							array_pop($scores);
						array_push($scores, array($mystery, $turn));
						$scores = bubble_sort($scores);
						
						$mystery = rand(1, 100);
						$scores = serialize($scores);
						echo "<input type='hidden' name='number' />
								<input type='hidden' name='turn' value=0 />
								<input type='hidden' name='mystery' value=$mystery />
								<input type='hidden' name='scores' value=$scores />
								<input type='submit' value='Restart' />";
					}
				}
				else
				{
					echo "Try: <input type='number' name='number' autofocus />
						<input type='hidden' name='turn' value=0 />
						<input type='hidden' name='scores' value=$scores />
						<input type='submit' value='Submit' />";
				}
				echo "</form>";
				
				echo "<br/>";
				$scores = unserialize($scores);
				if (!is_array($scores))
					$scores = array();
				echo "<table id='scores'>";
				echo "<tr>
						<td></td>
						<td id='table-header'>Rank</td>
						<td id='table-header'>Mystery</td>
						<td id='table-header'>Turns</td>
					</tr>";
				for($i = 0; $i < sizeof($scores); $i++)
				{
					echo "<tr>";
					switch($i)
					{
						case 0:
							echo "<td><img src='img/gold.jpg' id='trophy'/></td>";
							break;
						case 1:
							echo "<td><img src='img/silver.jpg' id='trophy'/></td>";
							break;
						case 2:
							echo "<td><img src='img/bronze.jpg' id='trophy'/></td>";
							break;
						default:
							echo "<td></td>";
							break;
					}
					echo "<td class='table-row'>".($i+1)."</td>";
					for($j = 0; $j < 2; $j++)
					{
						echo "<td class='table-row'>".$scores[$i][$j]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
			else
			{
				$mystery = rand(1, 100);
				$scores = serialize(array());
				echo "<form method='post'>
						<input type='hidden' name='number' />
						<input type='hidden' name='turn' value=0 />
						<input type='hidden' name='mystery' value=$mystery />
						<input type='hidden' name='scores' value=$scores />
						<input type='submit' value='Start' />
					</form>";
			}
		?>
	</body>
	<footer>
			<hr/>
            CST 336 - Internet Programming. 2018&copy; TORDJMAN
			<br/><br/>
	</footer>
</html>