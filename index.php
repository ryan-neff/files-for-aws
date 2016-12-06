
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="pe">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- Including CSS & jQuery Dialog UI Here-->
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>	
	<title>People's  Pets</title>
</head>
<body>
	<div class="panel panel-default">
		<div class="panel-heading">A Big List of Pets and How Much They Cost</div>
		<div class="panel-body">
			<p>
			This is a big list of pets and how much they cost to upkeep. You may add your pet as well.
			</p>
			<center>
				<div id = "createForm">
  					<form method="POST" action = "<?= $_SERVER['PHP_SELF'] ?>">
  						 <input type = "text" id = "type" placeholder='Type of Pet' name="typePet">
   						 <input type = "text" id = "price" placeholder = "Cost of Pet" name = "cost">
   						 <input type ="submit" id = "submit" name="submit"class="btn-success" value="Add Pet">
  					</form>
 				</div>
			</center>
		</div>
		<table class="table table-striped" id="mainTable">
			<th>ID #</th>
			<th>Type</th>
			<th>Price</th>
			<tbody>
			<?php populateTable();?>
		    </tbody>
		</table>
	</div>

<?php
	class Pets {
		public $id;
		public $type ="";
		public $price;

	}
     $pets = new Pets();
	function getAllPets(){	
    	$curl = curl_init();

    	curl_setopt($curl, CURLOPT_URL, "https://712x9uf0jk.execute-api.us-west-2.amazonaws.com/prod/pets/");
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    	$result = curl_exec($curl);
    	return $result;
    	curl_close($curl);
	}

	function postPet($pets) {
		$curl = curl_init();
		
		$petString="{\"pets\": [ \n";
		foreach ($pets as $pet) {
			if(end($pets) == $pet){
				$petString .= "{\"id\": $pet->id, \"type\": \"$pet->type\", \"price\": $pet->price}";
			}else{
				$petString .= "{\"id\": $pet->id, \"type\": \"$pet->type\", \"price\": $pet->price},\n";
			}
		}
		$petString.= "]\n}";

		curl_setopt_array($curl, array(
  		CURLOPT_URL => "https://712x9uf0jk.execute-api.us-west-2.amazonaws.com/prod/pets/",
  		CURLOPT_RETURNTRANSFER => true,
  		CURLOPT_ENCODING => "",
  		CURLOPT_MAXREDIRS => 10,
  		CURLOPT_TIMEOUT => 30,
  		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  		CURLOPT_CUSTOMREQUEST => "POST",
  		CURLOPT_POSTFIELDS => $petString
		));

    	$result = curl_exec($curl);

    	curl_close($curl);
	 }

	function populateTable() {
		$pets = json_decode(getAllPets());
		foreach($pets as $pet) {
			# code...
		echo("	
			<tr>
				<td>$pet->id </td>
				<td>$pet->type </td>
				<td>$pet->price </td>
			</tr>
  		");
		}

	}
	if(isset($_POST['submit'])) {
		$pets = json_decode(getAllPets());
		$newPet = new Pets();
		$newPet->id = (end($pets)->id) + 1;
		$newPet->type=$_POST['typePet'];
		$newPet->price=$_POST['cost'];
		$pets[] = $newPet;
		?>
	 	<script type="text/javascript"> 
		$('#mainTable').append('<tr><td><?php echo($newPet->id)?></td><td><?php echo($newPet->type)?></td><td><?php echo($newPet->price)?></td></tr>');
	 	</script><?php
	 	postPet($pets);
	}
?>

</body>
</html>