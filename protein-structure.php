
<?php
    include 'db-connect.inc.php';
    $id = $_POST['id'];
    $result['proteininfo'] = queryProteinInformation($conn, $id);
    echo json_encode($result);

function queryProteinInformation($conn, $id) {

    $select = 'SELECT pstc.PDB, uniprot.uniprot_AC, uniprot.function, uniprot.name, interactors.id ';

    $query = $select. '
                FROM interactors interactors
                LEFT JOIN protein_structures pstc
                on interactors.id = pstc.GeneID
                LEFT JOIN uniprot uniprot
                on interactors.id = uniprot.gene_ID
                WHERE interactors.id =' . $id;
    
    $rows = query($conn, $query);

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