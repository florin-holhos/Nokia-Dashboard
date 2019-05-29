<?php 
$currentPage = "home";
include 'header.inc.php'; 
if($user->isLoggedin())
{
    if(isset($_SESSION['admin']))
    {
        $uid = $_SESSION['admin'];
    }
    else
    {
        $uid = $_SESSION['user'];
    }
    if(!$user->isActive($uid))
    {
        $user->redirect("verify");
    }
}
?>
<style>
    .pad {
        padding-top: 100px;
    }

    .sss {
        background-color: rgba(100, 100, 100, 0.1);
        color: white;
    }

    @media only screen and (min-width: 1200px){
        .sss {
            max-width: 30% !important;
            border-radius: 5px;
        }     
    }

    .sss h2 {
        padding-top: 10px;
    }

    .scroll {
        overflow: auto;
        height: 400px;
        padding: 10px;
        opacity: 1;
        transition: 0.7s opacity;
    }
</style>
<!-- Content -->
<div class="row pad">
    <div class="col <?php if(isset($_SESSION['admin'])) { echo 'sss'; }?>">
        <?php 
    if(isset($_SESSION['admin']))
    {
    ?>
        <center>
            <h2>Recent Posts</h2>
        </center>
        <hr>
        <div class="postList scroll"></div>
        <?php } ?>
    </div>
    <div class="col">
        <?php 
        if(isset($_SESSION['admin']))
        {
            include 'ticketList.php'; 
        }
        elseif(isset($_SESSION['user']))
        {
            include 'userPage.php';
        }
        else
        {
            include 'welcomePage.php';
        }
        ?>
    </div>

    
</div>
<!-- Content -->
<?php include 'footer.inc.php'; ?>
<script>
    $(document).ready(function () {
        $('.postList').load("posts.php");

        setInterval(() => {
            $('.postList').load("posts.php");
        }, 1000);
    });
</script>

<!--
<script type="text/javascript">
    var ctxL = document.getElementById("lineChart").getContext('2d');
    var gradientFill = ctxL.createLinearGradient(0, 0, 0, 290);
    gradientFill.addColorStop(0, "rgba(173, 53, 186, 1)");
    gradientFill.addColorStop(1, "rgba(173, 53, 186, 0.1)");
    var myLineChart = new Chart(ctxL, {
        type: 'line',ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1

        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                label: "My First dataset",
                data: [0, 65, 45, 65, 35, 65, 0],
                backgroundColor: gradientFill,
                borderColor: [
                    '#AD35BA',
                ],
                borderWidth: 2,
                pointBorderColor: "#fff",
                pointBackgroundColor: "rgba(173, 53, 186, 0.1)",
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

-->
