<?php
/*
 * This is the logic file for index.php; it's job is to check the
 * SESSION for results, and if available, store the results in variables we
 * can display in index.php
 */

#session_start();

#initialize variables
$hasErrors = false;
$month = null;
$dayMaxErr = null;
$errMessage = null;
$dayErr = false;
$birthday = null;

# Get `results` data from session, if available
if (isset($_SESSION['results'])) {
    $results = $_SESSION['results'];

    $day = $results['day'];
    $month = $results['month'];
    $maxDay = $results['maxDay'];
    $dayMaxErr = $results['dayMaxErr'];
    $year = $results['year'];
    $checked = $results['checked'];
    $weekDay = $results['weekDay'];
    $birthday = $results['birthday'];
    $errors = $results['errors'];
    $hasErrors = $results['hasErrors'];

    

    if (($hasErrors) && ($month == '')) {
        $dayErr = true;
        $errMessage = '<--DAY MUST NOT BE BLANK';
    }
    if (!($dayMaxErr == '')) {
        $dayErr = true;
        $errMessage = $dayMaxErr;
    }
                

    # TIP: Because the key values for $results all match the variable names we set them do,
    # we could simplify the above 4 lines using PHP's extract function:
    #
    # extract($results);
    #
    # http://php.net/manual/en/function.extract.php
}
# Clear session data so our search is cleared when the page is refreshed
session_unset();

