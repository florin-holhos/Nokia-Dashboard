<?php 
include 'header.inc.php'; 
// Conditii
// Daca ticketul X se gaseste in TicketHistory, atunci se afiseaza o lista cu tichete
?>
<!-- Content -->
<div class="row">
    <div class="col">
        <?php 
        if(isset($_SESSION['admin']))
        {
            include 'historyTicketList.php'; 
        }
        ?>
    </div>
</div>
<!-- Content -->
<?php include 'footer.inc.php'; ?>