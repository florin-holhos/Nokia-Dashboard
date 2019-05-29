<?php

     $doneStatus = "Done";
     $getTicketStatement = $conn->prepare("SELECT * FROM tickets WHERE Status <> :stat AND Issued_by = :uid ORDER BY Priority");
     $getTicketStatement->bindParam(":stat", $doneStatus, PDO::PARAM_STR);
     $getTicketStatement->bindParam(":uid", $_SESSION['admin'], PDO::PARAM_INT);
     $getTicketStatement->execute();

?>
<div class="ticketList">
    <h2 style="display: inline;">Ticket list (<span id="ticketNumber"></span>)</h2>
    <span style="float: right; font-size: 30px; display: inline;"><i class="fas fa-history ticketHistory"
            title="Ticket history"></i> </span>
    <div class="ticketLL" style="display:none;">

    </div>
    <div class="Err" style="display: none;">
        <h2>No tickets to show!</h2>
    </div>
</div>

<script>
    $(document).ready(function () {
     

        $('.ticketHistory').click(function (e) {
            e.preventDefault();

            window.location.href = "ticketHistory.php";
        });

        //AJAX
        $('.ticketLL').load('tableData.php');

        $('#ticketNumber').load("getTicketNumber.php");

        (function () {
            $.ajax
                ({
                    url: 'getTicketList.php',
                    context: document.body,
                    success: function (response) {
                        if (response == 0) {
                            $('.ticketLL').fadeOut();
                            $('.Err').fadeIn();
                        }
                        else {

                            $('.Err').fadeOut();
                            $('.ticketLL').fadeIn();
                            $('.ticketLL').load('tableData.php');
                        }
                    }
                });

            $('#ticketNumber').load('getTicketNumber.php');
        })();



    });
</script>