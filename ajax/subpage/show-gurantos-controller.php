     
     <?php
        require '../../config.php';

        $searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);
        $searchClient = filter_var($_POST['searchClient'], FILTER_DEFAULT);
        // Get the maximum value of the column
        $clientSql = "SELECT MAX(id) AS max_value FROM tbl_loan";
        $cilentStmt = $db->prepare($clientSql);
        $cilentStmt->execute();

        // Fetch the result
        $clientResult = $cilentStmt->fetch(PDO::FETCH_ASSOC);

        $maxValue = $clientResult['max_value'];

        $maxValue = (int)$maxValue + 1;

        $loanNo = "loan No-" . $maxValue;

        try {
            echo " <table class='table table-striped table-align-left' id='gurantosViewTable'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>NIC</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Monthly Salary</th>
                        <th>Other Details</th>
                    </tr>
                </thead>
                <tbody>";
            $sql = "SELECT * FROM tbl_gurantors ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $i = 1;
            while ($row = $stmt->fetchObject()) {
                $name = $row->name;
                $nicNumber = $row->nicNumber;
                $address = $row->address;
                $phone = $row->phone;
                $monthlySalary = $row->monthlySalary;
                $otherDetails = $row->otherDetails;
                $clientId = $row->clientId;
                $productId = $row->productId;
                $newLoan = $row->newLoan;

                if ($clientId == $searchClient && $productId == $searchProduct && $newLoan == $loanNo) {
                    echo "<tr>";
                    echo  "<td>$i</td>";
                    echo "<td>$name</td>";
                    echo "<td>$nicNumber</td>";
                    echo "<td>$address</td>";
                    echo "<td>$phone</td>";
                    echo "<td>$monthlySalary</td>";
                    echo "<td>$otherDetails</td>";
                    echo "</tr>";
                    $i++;
                }
            }
            echo "</tbody>
            </table>";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }



        ?>