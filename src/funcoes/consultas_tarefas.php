

<?php //exemplo se houver a conexão servidor_host, user root, sem senha, bd com nome dbryze

	$conn = new mysqli("localhost", "root", "", "dbryze");

	if($conn->connect_error){
		echo "ERROR ". $conn->connect_error;
	}

//INCLUIR 
$result_POST = $conn->query("INSERT INTO tarefas(nome, classe, inicio, fim)VALUES('$nome', '$classe', '$inicio', '$fim')");
																									     
//ATUALIZAR
$result_PUT = $conn->query("UPDATE tarefas SET (nome = '$nome', classe = '$classe',  inicio = '$inicio', fim = '$fim') where id='$id'"); //usando id session 


//DELETAR
$result_DELETE = $conn->query("DELETE FROM tarefas WHERE id = '$id'"); //Deleta o cliente logado 
//session_destroy(); //Derruba o cliente do servidor apos limpar os dados 

//LER 
$result_GET = $conn->query("SELECT * FROM tarefas ORDER BY id ASC"); //lista todos os usuarios logados
$data = array(); //Exemplo sem utilizar a função mysqli_query
while ($row = $result->fetch_assoc()) {	
	array_push($data, $row); 
}
echo json_encode($data);//Listando users

//todos os exemplos à serem testados 
?>

 