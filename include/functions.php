<?php

//Export data from array
function dataValue($data, $column)
{
    if (isset($data[$column])) {
        return $data[$column];
    } else {
        return '';
    }
}
//Export data from array



//Random Code
function randomCode($lenth)
{
    $alphabet = '0123456789';
    $pass = [];
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $lenth; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
//Random Code

function generateRandomNumericCode($length) {
    $min = pow(10, $length - 1); 
    $max = pow(10, $length) - 1; 
    return mt_rand($min, $max); 
}

//Random Text
function randomText($lenth)
{
    $alphabet = '0123456789ABCDEFGHIJKLMNOPQUSTUVWXYZabcdefghijklmnopquestuvwxyz';
    $pass = [];
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $lenth; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
//Random Text

//Build Calander
function build_calendar($today, $month, $year, $availableDaysArray, $rosterDaysArray)
{
    $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $calendar = "<table class='table calander-table'>";
    $calendar .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    $currentDay = 1;
    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $dayName = getWeekdayName($dayOfWeek);


        $todayDate = date('d-m-Y', strtotime($currentDay . '-' . $month . '-' . $year));

        if ($today >= $currentDay) {
            if ($today == $currentDay) {
                $calendar .= "<td class='day'><span class='today-date-selected'>$currentDay</span></td>";
            } else {
                $calendar .= "<td class='day muted'>$currentDay</td>";
            }
        } else {
            if (in_array($dayName, $availableDaysArray) && !(in_array($todayDate, $rosterDaysArray))) {
                $calendar .= "<td class='day'>";
                $calendar .= $currentDay;
                $calendar .= "<br><span class='badge calander-available-day' data-date='$todayDate'>Available</span>";
                $calendar .= "</td>";
            } else {
                $calendar .= "<td class='day'>";
                $calendar .= $currentDay;
                $calendar .= "<br><span class='badge calander-unavailable-day'>as</span>";
                $calendar .= "</td>";
            }
        }
        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";
    return $calendar;
}
//Build Calander

//Build Doctor Calander
function buildDocCalendar($today, $month, $year, $availableDaysArray, $rosterDaysArray)
{
    $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $calendar = "<table class='table calander-table'>";
    $calendar .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    $currentDay = 1;
    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $dayName = getWeekdayName($dayOfWeek);


        $todayDate = date('d-m-Y', strtotime($currentDay . '-' . $month . '-' . $year));

        if ($today >= $currentDay) {
            if ($today == $currentDay) {
                $calendar .= "<td class='day'>";
                $calendar .= "<span class='today-date-selected'>$currentDay</span>";
                $calendar .= "</td>";
            } else {
                $calendar .= "<td class='day muted'>";
                $calendar .= $currentDay;
                $calendar .= "</td>";
            }
        } else {
            if (in_array($dayName, $availableDaysArray) && !(in_array($todayDate, $rosterDaysArray))) {
                $calendar .= "<td class='day'>";
                $calendar .= $currentDay;
                $calendar .= "<br><span class='badge calander-available-day' data-date='$todayDate'>Available</span>";
                $calendar .= "</td>";
            } else {
                $calendar .= "<td class='day'>";
                $calendar .= $currentDay;
                $calendar .= "<br><span class='badge calander-unavailable-day'>as</span>";
                $calendar .= "</td>";
            }
        }
        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";
    return $calendar;
}
//Build Doctor Calander

//Get Weekday name
function getWeekdayName($weekday_number)
{
    $weekday_names = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $weekday_index = $weekday_number % 7; // Ensure weekday number is in range 0-6
    return $weekday_names[$weekday_index];
}
//Get Weekday name

//Get QR Code
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

function getQrCode($url)
{
    $options = new QROptions(
        [
            'eccLevel' => QRCode::ECC_L,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'version' => 5,
        ]
    );

    return (new QRCode($options))->render($url);
}

//Get QR Code
