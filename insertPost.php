<?php

include 'conn.php';

try
{
    $statement = $conn->prepare("INSERT INTO posts(uid, post_content) VALUES(:uid, :postCont)");
    $statement->execute(array(
        ':uid' => $_SESSION['user'],
        ':postCont' => $_POST['postCont']
    ));

    return true;
}catch(PDOException $e)
{
    echo $e->getMessage();
}

?>