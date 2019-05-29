<?php
//Content
//Connection is already included
//And header
?>
<div class="row">
    <div class="col">
        <form id="writePost">
            <textarea name="postCont" id="" class="postWrite" cols="30" rows="3" placeholder="Write a post"></textarea>
            <input type="submit" id="send" class="sender btn btn-info">
        </form>
        <hr>
        <div class="postList"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.postList').load("posts.php");

        setInterval(() => {
            $('.postList').load("posts.php");
        }, 1000);

        $('#send').click(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'insertPost.php',
                data: $('#writePost').serialize(),
                success: function (response) {
                    $('.postList').load("posts.php");
                    $('.postWrite').val("");
                }
            });
        });
    });
</script>