<?php
$db = new PDO('mysql:host=localhost;dbname=backbone_phpmysql', 'root', 'root');
$page = isset($_GET['p'])? $_GET['p'] : '';
if($page=='add'){
    $sql = "INSERT INTO crud values (:id,:nm,:em,:hp,:ad,:at)";
    $query = $db->prepare($sql);
    $query->execute(array(":id"=>null,":nm"=>$_POST['name'],":em"=>$_POST['email'],":hp"=>$_POST['phone'],":ad"=>$_POST['address'],":at"=>$_POST['active']));
} else if($page=='edit'){
    $sql = "UPDATE crud SET name= :nm, email= :em, phone= :hp, address= :ad, active= :at WHERE id = :id";
    $query = $db->prepare($sql);
    $query->execute(array(":id"=>$_POST['id'],":nm"=>$_POST['name'],":em"=>$_POST['email'],":hp"=>$_POST['phone'],":ad"=>$_POST['address'], ":at"=>$_POST['active']));
} else if($page=='trash'){
    $sql = "DELETE FROM crud WHERE id = :id";
    $query = $db->prepare($sql);
    $query->execute(array(":id"=>$_POST['id']));
} else if($page=='item'){
    $statement = $db->query("SELECT * FROM crud WHERE id = ".$_GET['id']);
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    echo json_encode($statement->fetch());
} else{
    $statement = $db->query('SELECT * FROM crud');
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    echo json_encode($statement->fetchAll());
}
?>