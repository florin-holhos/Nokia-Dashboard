<tr class="table-active">
    <th scope="row" class="text-center"><?php echo $ticket['Ticket_name']; ?></th>
    <td class="text-center"><a href="#" class="btn btn-success"><?php echo $ticket['Status']; ?></a></td>
    <td class="text-center"><?php echo $user->getIssuedBy($ticket['Issued_by']); ?></td>
    <td class="text-center"><?php echo $ticket['Deadline']; ?></td>
    <td class="text-center"><?php echo $ticket['Priority']; ?></td>
    <td class="text-center"><?php echo $ticket['Client']; ?></td>
</tr>