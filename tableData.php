    <div class="table-responsive">
        <table class="table table-hover" style="width: 100%;">
                <thead>
                    <style>
                        .col:nth-child(3){
                            display: none;
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
                                float: none;
                                text-align: center;
                                margin-top: 3%
                                width: 100%;
                            }

                            .dataTables_wrapper {
                                text-align: center;
                            }
                        }
                    </style>

                    <tr>
                        <th class="text-center">Ticket Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Issued By</th>
                        <th class="text-center">Timer</th>
                        <th class="text-center">Deadline</th>
                        <th class="text-center">Priority</th>
                        <th class="text-center">Client</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            <tbody class="tickete">
                
            <?php
                include 'conn.php';
                try
                {
                    // update tickets before displaying
                    $updateTicket = $conn->prepare("UPDATE tickets SET Status = 'Done' WHERE Issued_by = :uid AND SYSDATE() > Deadline");
                    $updateTicket->bindParam(":uid", $_SESSION['admin'], PDO::PARAM_INT);
                    $updateTicket->execute();

                    $doneStatus = "Done";
                    $getTicketStatement = $conn->prepare("SELECT * FROM tickets WHERE Status <> :stat AND Issued_by = :uid ORDER BY Priority");
                    $getTicketStatement->bindParam(":stat", $doneStatus, PDO::PARAM_STR);
                    $getTicketStatement->bindParam(":uid", $_SESSION['admin'], PDO::PARAM_INT);
                    $getTicketStatement->execute();

                    //Foreach
                    $getTicket = $getTicketStatement->fetchAll();

                    if($getTicketStatement->rowCount() > 0)
                    {
                        // added ID column for sorting

                        foreach($getTicket as $ticket)
                        {
            ?>
                    
                    <script type="text/javascript">
                    $(document).ready(function() {
                        let seconds = <?php echo $user->getSeconds($ticket['Ticket_id']); ?>;
                        seconds = seconds < 0 ? 0 : seconds;
                        startCountDown("clockDiv<?php echo $ticket['Ticket_id']; ?>", seconds, <?php echo $user->getSecondsTotal($ticket['Ticket_id']); ?>);
                    });
                    </script>
                

                    <style>
                        .activeTickets td, th
                        {
                            font-size: 17px;
                            text-align: center;
                            font-weight: 500;
                            padding: 0;
                        }
                    </style>

                    <tr class="table-active activeTickets">
                        
                        <th scope="row" class="text-center"><?php echo $ticket['Ticket_name']; ?></th>
                        <td class="text-center"><a href="#" class="btn btn-success"><?php echo $ticket['Status']; ?></a></td>
                        <td class="text-center"><?php echo $user->getIssuedBy($ticket['Issued_by']); ?></td>
                        <td>
                            <div class="timerDiv">
                    			 <div id="clockDiv<?php echo $ticket['Ticket_id']; ?>" class="CountdownC" ></div>
                    	   </div>
                        </td>
                        <td class="text-center"><?php echo $ticket['Deadline']; ?></td>
                        <td class="text-center"><?php echo $ticket['Priority']; ?></td>
                        <td class="text-center"><?php echo $ticket['Client']; ?></td>
                        <td><a href="#" id="tick<?php echo $ticket['Ticket_id']; ?>" class="actionPre">
                                <h3><i class="fas fa-check-circle"></i></h3>
                            </a>
                                <script>
                                    $('#tick<?php echo $ticket['Ticket_id']; ?>').click(function(e) {
                                        e.preventDefault();
                                        $.ajax
                                        ({
                                            type: 'POST',
                                            url: "doneTicket.php?TID=" + <?php echo $ticket['Ticket_id']; ?>,
                                            success: function(response)
                                            {
                                                alert("Ticket with ID:" + <?php echo $ticket['Ticket_id']; ?> + " has been resolved!");
                                                location.reload();
                                            }
                                        });
                                    });
                                </script>
                        </td>
                    </tr>

                    <?php
                            }
                        }
                        else
                        {
                            echo 0;
                        }
                        
                    }catch(PDOException $e)
                    {
                        echo $e->getMessage();
                    }
                    ?>
            </tbody>
</table>
</div>
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