@extends('layouts.master')

@section('title')
    <h1>Add a Birthday</h1>
@endsection

@section('content')
    <?php
    #initialize variables
    $hasErrors = false;
    $month = null;
    $maxDay = null;
    $dayMaxErr = null;
    $weekDay = null;
    $errMessage = null;
    $dayErr = false;
    $birthday = null;
    $checked = null;
    $fortune = null;
    $zodiacSign = null;
    $chineseSign = null;
    $birthstone = null;

    $months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];
    ?>
    <div align='center'>
        <div>All Birthday Inputs Are Required</div>
        <section id='main'>
            <form method='POST' action='/birthdays/process'>
                {{ csrf_field() }}

                <label for='birthdayTitle'>Birthday Title</label><br>
                <input type='text'
                       name='birthdayTitle'
                       id='birthdayTitle'
                       autocomplete='off'
                       style="width: 100%; height: 30px;"
                       value='{{ old('birthdayTitle') }}'>

                @include('includes.error-field', ['fieldName' => 'birthdayTitle'])<br>


                <label for='month'>Select the month</label><br>
                <select name='month' id='month' style="width: 100%; height: 30px;">
                    <option value='' <?php if ($month == null) echo 'selected' ?>>Select a month...</option>
                    <?php foreach($months as $monthName) { ?>
                    {
                    <option value="<?= $monthName ?>"><?php if ($month == $monthName) echo 'selected' ?>><?=$monthName ?></option>
                    }
                    <?php
                    } ?>
                </select>
                @include('includes.error-field', ['fieldName' => 'month'])<br>


                <label for='day'>Enter the day number (must be from 1 - 31, inclusive)</label><br>
                <input type='number'
                       name='day'
                       id='day'
                       style="width: 100%; height: 30px;"
                       min='1'
                       max='<?= $maxDay ?? '' ?>'
                       autocomplete='off'
                       value='{{ old('day') }}'>
                @include('includes.error-field', ['fieldName' => 'day'])<br>

                <label for='year'>Enter the year number (must be from 1900 - 2018, inclusive)</label><br>
                <input type='number'
                       name='year'
                       id='year'
                       style="width: 100%; height: 30px;"
                       min='1900'
                       max='2018'
                       autocomplete='off'
                       value='{{ old('year') }}'>
                @include('includes.error-field', ['fieldName' => 'year'])

                <label>Tell me my fortune
                    <input type='checkbox'
                           name='checked' <?php if (isset($checked) and $checked) echo 'checked' ?> >
                </label>

                <p></p>
                <input type='submit' value='Submit' class='btn btn-primary'>
            </form>
        </section>
    </div>

    @if(count($errors) > 0)
        <div class='alert alert-danger'>Please fix the errors above</div>
    @endif

@endsection