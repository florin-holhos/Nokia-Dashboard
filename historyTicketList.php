<div class="ticketList">
    <?php
     $doneStatus = "Done";
     $getTicketStatement = $conn->prepare("SELECT * FROM tickets WHERE Status = :stat AND Issued_by = :uid ORDER BY Priority");
     $getTicketStatement->bindParam(":stat", $doneStatus, PDO::PARAM_STR);
     $getTicketStatement->bindParam(":uid", $_SESSION['admin'], PDO::PARAM_INT);
     $getTicketStatement->execute();
    ?>
            <h2 style="display: inline;">History Ticket list (<?php echo $getTicketStatement->rowCount(); ?>)</h2>
            <!--
            <span style="float: right; font-size: 30px; display: inline;" class="excelExport"><i class="far fa-file-excel"
                    title="Export to excel"></i></span>  -->

<style>
.col:nth-child(3){
    display: none;
}

.table {
    width: 100%;
}

.pad, .ticketList {
    margin-top: 1%;
    padding: 0;
}

.postList {
    height: 400px;
}

.dt-buttons {
    width: 60%;
}

.btn-group .btn {
    margin: 5px;
}

.dataTables_filter {
    width: 40%;
    float: right;
    display: inline-flex;
    justify-content: flex-end;
    margin-top: 0.5rem;
}

.dataTables_filter label {
    margin: 0;
    padding: 0;
}

.form-control {
    border-radius: 5px;
}

@media only screen and (max-width: 768px){
    .dt-buttons {
        width: 100%;
    }

    .dataTables_filter {
        width: 100%;
        display: inline-block;
        justify-content: unset;
        float: none;
        text-align: center;
    }

}
</style>

        <div class="table-responsive">
            <table class="table table-hover" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center">Ticket Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Issued By</th>
                        <th class="text-center">Deadline</th>
                        <th class="text-center">Priority</th>
                        <th class="text-center">Client</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try
                    {
                        //Ticket history
                        $ticketHistory = $conn->prepare("SELECT * FROM tickets WHERE Status = :statusTicket");
                        $statusDone = "Done";
                        $ticketHistory->bindParam(":statusTicket", $statusDone, PDO::PARAM_STR);
                        $ticketHistory->execute();

                        //Foreach
                        $getTicketHistory = $ticketHistory->fetchAll();
                        foreach($getTicketHistory as $ticket)
                        {
                            include 'ticketHistoryContent.php'; 
                        }
                        
                    } catch(PDOException $e)
                    {
                        echo $e->getMessage();
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>

</div>
<!--
        <script>
        $(document).ready(function() {
            $('.excelExport').click(function(e){
                e.preventDefault();

                window.location.href = "exportTicketHistory.php";
            });
        });
        </script>
-->
<!-- DataTables -->
<script>
        $(document).ready(function() {
        $(".table").DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
            ],
            order: [[3, 'asc']] // sort by remaining time
            
        });
    }); 
</script>