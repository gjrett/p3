<?php
/*
 * This is the script that the form on index.php submits to
 * Its job is to:
 * 1. Get the data from the form request
 * 2. Process the form data and find the week day that matches the input date
 * 3. Store the results in the SESSION
 * 4. Redirect the visitor back to index.php
 */

#require 'includes/helpers.php';
require 'logic.php';
require 'Form.php';
require 'DateInfo.php';

use DWA\Form;
use DWA\DateInfo;

# We'll be storing data in the session, so initiate it
session_start();

# Instantiate our objects
$form = new Form($_GET);
$dateInfo = new DateInfo($_GET);

# Get data from form request
$month = $form->get('month');
$day = $form->get('day');
$year = $form->get('year');
$checked = $form->has('checked');

# Validate the form data
$errors = $form->validate([
    'month' => 'required',
    'day' => 'numeric|min:1|max:31',
    'year' => 'numeric|min:1900|max:2018'
]);

if (!$form->hasErrors) {
    #Process information

    #Add day of the month
    $calcNumber = $day;

    #Add month offset
    $monthOffset = [
        'January' => 6,
        'February' => 2,
        'March' => 2,
        'April' => 5,
        'May' => 0,
        'June' => 3,
        'July' => 5,
        'August' => 1,
        'September' => 4,
        'October' => 6,
        'November' => 2,
        'December' => 4
    ];

    $calcNumber += $monthOffset[$month];

    #Add decade year offset
    $yearDecade = ($year / 10);

    $yearOffset = [
        190 => 1,
        191 => 6,
        192 => 5,
        193 => 3,
        194 => 2,
        195 => 0,
        196 => 6,
        197 => 4,
        198 => 3,
        199 => 1,
        200 => 0,
        201 => 5
    ];

    $calcNumber += $yearOffset[$yearDecade];

    #Add last digits of the year

    $yearLastDigit = ($year % 10);
    $calcNumber += $yearLastDigit;

    #Add leap year offset

    if (($yearDecade % 2 == 0) && ($yearLastDigit >= 4)) {
        $calcNumber += 1;
        if ($yearLastDigit >= 8) {
            $calcNumber += 1;
        }
    }
    if (($yearDecade % 2 != 0) && ($yearLastDigit >= 2)) {
        $calcNumber += 1;
        if ($yearLastDigit >= 6) {
            $calcNumber += 1;
        }
    }

    #If the month is either January or February of a leap year. subtract 1.
    if (($month == 'January') || ($month == 'February')) {
        if (($yearDecade % 2 == 0) && (($yearLastDigit == 0) || ($yearLastDigit == 4) || ($yearLastDigit == 8))) {
            $calcNumber += -1;
        } else if (($yearDecade % 2 != 0) && (($yearLastDigit == 2) || ($yearLastDigit == 6))) {
            $calcNumber += -1;
        }
    }

    #get last day of the month to validate day
    $maxDay = $dateInfo->findMaxDay($month);
    #Add 1 if it's February of a leap year
    if (($month == 'February') && ($dateInfo->isLeapYear($year))) {
        $maxDay += 1;
    }

    #Divide by 7, remainder is day of the week
    $dayOfWeekNumber = ($calcNumber % 7);

    $dayOfWeek = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];
    $weekDay = $dayOfWeek[$dayOfWeekNumber];

    #If the input day is past the end of a month, such as 30 for February, clear $weekDay
    if ($day > $maxDay) {
        $weekDay = '';
        $dayMaxErr = '<--DAY INPUT OVER MAX FOR CHOSEN MONTH';
    }

    #If input date is a birthday, set happy birthday value

    if ($checked) {
        $birthday = 'HAPPY BIRTHDAY!';
    } 
}
# Store our results data in the SESSION so it's available when we redirect back to index.php
$_SESSION['results'] = [
    'errors' => $errors,
    'hasErrors' => $form->hasErrors,
    'month' => $month,
    'day' => $day,
    'maxDay' => $maxDay,
    'dayMaxErr' => $dayMaxErr,
    'year' => $year,
    'checked' => $checked,
    'weekDay' => $weekDay,
    'birthday' => $birthday
];

# Redirect back to the form on show.blade.php
header('Location: show.blade.php');
