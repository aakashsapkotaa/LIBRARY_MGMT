<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_borrow.php'); ?>
<div class="container">
    <div class="margin-top">
        <div class="row">
            <div class="span12">
                <div class="alert alert-info"><strong>Borrowed Books</strong></div>
                <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                    <thead>
                        <tr>
                            <th>Book title</th>
                            <th>Borrower</th>
                            <th>Class</th>
                            <th>Date Borrow</th>
                            <th>Due Date</th>
                            <th>Date Returned</th>
                            <th>Borrow Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM borrow
            LEFT JOIN member ON borrow.member_id = member.member_id
            LEFT JOIN borrowdetails ON borrow.borrow_id = borrowdetails.borrow_id
            LEFT JOIN book ON borrowdetails.book_id =  book.book_id 
            ORDER BY borrow.borrow_id DESC";

                        $stmt = mysqli_prepare($conn, $query);

                        if ($stmt) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            while ($row = mysqli_fetch_array($result)) {
                                $id = $row['borrow_id'];
                                $book_id = $row['book_id'];
                                $borrow_details_id = $row['borrow_details_id'];
                                ?>
                                <tr class="del<?php echo $id ?>">
                                    <td>
                                        <?php echo $row['book_title']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['firstname'] . " " . $row['lastname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['year_level']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['date_borrow']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['due_date']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['date_return']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['borrow_status']; ?>
                                    </td>
                                    <td>
                                        <a rel="tooltip" title="Return" id="<?php echo $borrow_details_id; ?>"
                                            href="#delete_book<?php echo $borrow_details_id; ?>" data-toggle="modal"
                                            class="btn btn-success"><i class="icon-check icon-large"></i>Return</a>
                                        <?php include('modal_return.php'); ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <?php
                            }

                            mysqli_stmt_close($stmt);
                        } else {
                            die(mysqli_error($conn));
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script>
                $(".uniform_on").change(function () {
                    var max = 3;
                    if ($(".uniform_on:checked").length == max) {

                        $(".uniform_on").attr('disabled', 'disabled');
                        alert('3 Books are allowed per borrow');
                        $(".uniform_on:checked").removeAttr('disabled');

                    } else {

                        $(".uniform_on").removeAttr('disabled');
                    }
                })
            </script>
        </div>
    </div>
</div>
<?php include('footer.php') ?>