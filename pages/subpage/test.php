<?php

try {
    $sqlPMethod = 'SELECT * FROM tbl_savings_total ';
    $stmt = $db->prepare($sqlPMethod);
    $stmt->execute();
    $i = 1;

    while ($row = $stmt->fetchObject()) {
        $id = $row->id;
        $clientId = $row->clientId;
        $date = $row->date;
        $dateTime = DateTime::createFromFormat('m-d-Y H:i:s', $date);
        $formattedDate = $dateTime->format('Y-m-d');
        $currentDate = date('Y-m-d');
        $lastThreeMonthsDate = date('Y-m-d', strtotime('-6 months', strtotime($currentDate)));

        if ($formattedDate < $lastThreeMonthsDate) {
            $sql = "UPDATE tbl_client_users SET status = '1' WHERE clientId = '$clientId'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
    

    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
