<?php
require 'includes/process.php';
?>

@extends('layouts.master')

@section('head')
   <h1>'HAPPY BIRTHDAY'</h1>
@endsection

@section('content')

 <div>
    <section id='main'>
        <form method='GET' action='process.php'>
            <label>The week day for the input birth date is:<br>
                <input type='text' readonly name='weekDay' size='11' value='<?= $weekDay ?? '' ?>'>
            </label>
            <label>
                <input type='text'
                       readonly
                       name='birthday'
                       size='17'
                       style="border:none"
                       value='<?= $birthday ?? '' ?>'>
            </Label>
        </form>
    </section>
</div>
@endsection