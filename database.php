
<?php
    include 'db-connect.inc.php';
   $id = $_POST['id'];
   $result['gene']['main'] = queryGene($conn, $id);
   $result['gene']['interactors'] = queryInteractors($conn, $id);
    //$result['interactions'] = queryInteractionss($conn, 6416);
    echo json_encode($result);

   //var_dump($result);


function queryGene($conn, $id) {

    $select = 'SELECT interactor.symbol as Symbol, interactor.Id as ID';

    $query = $select. '
                FROM interactors interactor WHERE interactor.Id =' . $id;
    
    $rows = query($conn, $query);

    return $rows;
}

function queryInteractionss($conn, $id) {

    $query = 'SELECT DISTINCT id, id_interaction FROM interactions WHERE id IN (6416, 2318, 9043, 5871, 1326, 207, 23162, 4296, 4216, 409)
              AND id_interaction IN (6416, 2318, 9043, 5871, 1326, 207, 23162, 4296, 4216, 409)';

    // $queryx = 'SELECT DISTINCT id, id_interaction FROM interactions  WHERE id IN ('. htmlspecialchars(implode($id, ','),ENT_QUOTES, "UTF-8") .')
   // AND id_interaction IN ('. htmlspecialchars(implode($id, ','),ENT_QUOTES, "UTF-8") .')';

    $rows = query($conn, $query);

    return $rows;
}

function queryInteractors($conn, $id) {

   // $select = 'SELECT interactor_one.symbol as Symbol, interactor_one.id as Id, interactor_two.id as Id2';

  //  $query = 'SELECT interactor_one.symbol, interactor_one.id as ID1, interactor_two.id as ID2 FROM interactors interactor_one INNER JOIN interactions ON interactor_one.id = interactions.id INNER JOIN interactors interactor_two ON interactor_two.id = interactions.id_interaction WHERE interactor_two.id = ' .$id .' UNION ALL SELECT interactor_one.symbol, interactor_one.id as ID1, interactor_two.id as ID2 FROM interactors interactor_one INNER JOIN interactions ON interactor_one.id = interactions.id_interaction INNER JOIN interactors interactor_two ON interactor_two.id = interactions.id WHERE interactor_two.id = ' .$id;

    $querys = 'SELECT interactor_one.symbol, interactor_one.id as ID1, interactor_two.id as ID2 FROM interactors interactor_one INNER JOIN interactions ON interactor_one.id = interactions.id INNER JOIN interactors interactor_two ON interactor_two.id = interactions.id_interaction WHERE interactor_two.id = 6416 UNION ALL SELECT interactor_one.symbol, interactor_one.id as ID1, interactor_two.id as ID2 FROM interactors interactor_one INNER JOIN interactions ON interactor_one.id = interactions.id_interaction INNER JOIN interactors interactor_two ON interactor_two.id = interactions.id WHERE interactor_two.id = ' .$id;

    $rows = query($conn, $querys);

    return $rows;
}

function queryInteractions($conn, $id) {

    // $query = 'SELECT DISTINCT Id, Id2 FROM interactions WHERE Id IN ('. htmlspecialchars(implode($id, ','), END_QUOTES, "UTF-8") .')
     //          AND Id2 IN ('. htmlspecialchars(implode($id, ','), END_QUOTES, "UTF-8") .')';
 
     $queryx = 'SELECT DISTINCT id, id_interaction FROM interactions  WHERE id IN ('. htmlspecialchars(implode($id, ','),ENT_QUOTES, "UTF-8") .')
     AND id_interaction IN ('. htmlspecialchars(implode($id, ','),ENT_QUOTES, "UTF-8") .')';
 
     $rows = query($conn, $queryx);
 
     return $rows;
 }


function query($conn, $query) {
	$rows = [];
	
	$result = mysqli_query($conn, $query);
	if($result) {
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$rows[] = $row;
		}
	}
	return $rows;
 }