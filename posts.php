<?php
include 'conn.php';

try
{
    $statement = $conn->prepare("SELECT * FROM posts WHERE hidden=0 ORDER BY id DESC");
    $statement->execute();

    $rows = $statement->fetchAll();
    if($statement->rowCount() > 0)
    {
        foreach($rows as $post)
        {
            ?>
                <div class="postcontent">
                    <div class="headerPost"><?php echo $user->getname($post['uid']);?></div>
                    <div class="bodyPost"><?php echo $post['post_content']; ?></div>
                    <div class="footerPost"><?php echo $post['posted_at']; ?></div>
                </div>
            <?php
        }
    }
}catch(PDOException $e)
{
    echo $e->getMessage();
}
?>

