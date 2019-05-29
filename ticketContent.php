<!-- <script type="text/javascript">
    $(document).ready(function() {
        startCountDown("clockDiv<?php echo $ticket['Ticket_id']; ?>", <?php echo $user->getSeconds($ticket['Ticket_id']); ?>);
    });
</script> -->
<style>
    .activeTickets td, th
    {
        font-size: 17px;
        text-align: center;
        font-weight: 500;
    }
</style>
<tr class="table-active activeTickets">
    <th scope="row" class="text-center"><?php echo $ticket['Ticket_name']; ?></th>
    <td class="text-center"><a href="#" class="btn btn-success"><?php echo $ticket['Status']; ?></a></td>
    <td class="text-center"><?php echo $user->getIssuedBy($ticket['Issued_by']); ?></td>
    <td><div class="timerDiv">
			<!-- <div id="clockDiv<?php echo $ticket['Ticket_id']; ?>" >	 -->
		</div>	
	</div></td>
    <td class="text-center"><?php echo $ticket['Deadline']; ?></td>
    <td class="text-center"><?php echo $ticket['Priority']; ?></td>
    <td class="text-center"><?php echo $ticket['Client']; ?></td>
    <td>{{ACTION}}</td>
</tr>