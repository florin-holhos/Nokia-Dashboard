<!-- Header -->
<?php 
include_once 'conn.php';

if(!$user->isLoggedin())
{
    $user->redirect("index.php");
}

$conn = "";
$currentPage = "newTick";
include 'header.inc.php'; 



?>
<!-- End Header -->

<!-- Content -->
<div class="container postContent">
    <div class="alert alert-dismissible alert-success ticketSuccess" style="display: none;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4 class="alert-heading">Success!</h4>
        <p class="mb-0">Your ticket has been sent!</p>
    </div>
    <div class="jumbotron ticket">
        <h2>Create a new Ticket</h2>
        <hr />
        <form id="ticketForm">
            <div class="form-group row">
                <label for="ticketName" class="col-sm-3 col-form-label">Ticket name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="ticketName" name="ticketName" value=""
                        placeholder="Ticket name">
                </div>
            </div>
            <div class="form-group row" style="display: none;">
                <label for="username" class="col-sm-3 col-form-label">Issued by</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control ff" id="issuer" name="issuedBy"
                        value="<?php echo $_SESSION['admin']; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleSelect1" class="col-sm-3 col-form-label">Priority</label>
                <div class="col-sm-9">
                    <select class="form-control" id="exampleSelect1" name="priority[]">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
            <!-- <div class="form-group row">
                <label for="exampleSelect1" class="col-sm-3 col-form-label">Deadline</label>
                <div class="col-sm-9">
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" placeholder="Select a deadline">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="form-group row">
                <label for="client" class="col-sm-3 col-form-label">Client</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="client" name="client" value=""
                        placeholder="Client name">
                </div>
            </div>
            <div class="form-group row">
                <label for="client" class="col-sm-3 col-form-label">Location</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="location" name="Location" value=""
                        placeholder="Enter location">
                </div>
            </div>
            <div class="form-group row">
                <label for="client" class="col-sm-3 col-form-label">Short description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows=5 placeholder="Short description" name="shortDesc"></textarea>
                </div>
            </div>
            <input type="submit" value="Submit" id="submitTicket" class="btn btn-success" />
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#submitTicket').unbind('click').bind('click', function (event) {
                event.preventDefault();
                $.ajax
                    ({
                        type: 'POST',
                        url: 'sendTicket.php',
                        data: $('#ticketForm').serialize(),
                        success: function (response) {
                            $('.ticketSuccess').show();
                        }
                    });
            });
        });
    </script>
</div>
</div>
</main>
<!-- End Content -->
<!-- Footer -->
<?php include 'footer.inc.php'; ?>
<!-- End Footer -->