<?php
require 'includes/logic.php';
?>

@extends('layouts.master')

@section('head')
<title>'HAPPY BIRTHDAY'</title>
@endsection

@section('content')

<h1>Birth Date Info</h1>
<h2>This program finds information about birth dates input by the user </h2>

<div>
    <section id='main'>
        <form method='GET' action='process.php'>
            <fieldset>
                <label>Select the month<br>
                    <select name='month'>
                        <option value='' <?php if ($month == null) echo 'selected' ?>>Choose one...</option>
                        <option value='January' <?php if ($month == 'January') echo 'selected' ?>>January</option>
                        <option value='February' <?php if ($month == 'February') echo 'selected' ?>>February</option>
                        <option value='March' <?php if ($month == 'March') echo 'selected' ?>>March</option>
                        <option value='April' <?php if ($month == 'April') echo 'selected' ?>>April</option>
                        <option value='May' <?php if ($month == 'May') echo 'selected' ?>>May</option>
                        <option value='June' <?php if ($month == 'June') echo 'selected' ?>>June</option>
                        <option value='July' <?php if ($month == 'July') echo 'selected' ?>>July</option>
                        <option value='August' <?php if ($month == 'August') echo 'selected' ?>>August</option>
                        <option value='September' <?php if ($month == 'September') echo 'selected' ?>>September</option>
                        <option value='October' <?php if ($month == 'October') echo 'selected' ?>>October</option>
                        <option value='November' <?php if ($month == 'November') echo 'selected' ?>>November</option>
                        <option value='December' <?php if ($month == 'December') echo 'selected' ?>>December</option>
                    </select><?php if (($hasErrors) && ($month == '')) echo '<font size="1.5" color="red"><--MONTH MUST NOT BE BLANK</font>'; ?>
                </label>
 

                <label>Enter the day number (must be from 1 - 31, inclusive)<br>
                    <input type='number'
                           name='day'
                           size='4'
                           min='1'
                           max='<?= $maxDay ?? '' ?>'
                           autocomplete='off'
                           value='<?= $day ?? '' ?>'
                </label><font size="1.5" color="red"><?php if ($dayErr) echo $errMessage; ?></font>

                <label>Enter the year number (must be from 1900 - 2018, inclusive)<br>
                    <input type='number'
                           name='year'
                           size='8'
                           min='1900'
                           max='2018'
                           autocomplete='off'
                           value='<?= $year ?? '' ?>'
                </label><?php if (($hasErrors) && ($month == '')) echo '<font size="1.5" color="red"><--YEAR MUST NOT BE BLANK</font>'; ?>

                <label>This is my birthday
                    <input type='checkbox' name='checked' <?php if (isset($checked) and $checked) echo 'checked' ?> >
                </label>

            </fieldset>

            <input type='submit' value='Submit' class='btn btn-primary'>
        </form>
    </section>
</div>

<?php if ($hasErrors): ?>
    <div class='errors alert alert-danger'>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>

@endsection