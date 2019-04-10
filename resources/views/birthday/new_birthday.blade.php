<?php
require 'includes/logic.php';
?>

@extends('layouts.master')

@section('head')
    <title>'What Is Your Sign'</title>
@endsection

@section('content')
    <div class="row">
        <div class="column side">
            <a href='/'><img src='/images/capricorn.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/aquarius.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/pisces.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/aries.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/taurus.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/gemini.png' id='logo' alt='Birthday Info'></a>
        </div>
        <div class="column middle">
            <div>
                <section id='main'>

                    <div>
                        <h4>You were born on a: {{ $weekDay }}</h4>
                        <h4>Zodiac Sign is: {{ $zodiacSign }}</h4>
                        <h4>Chinese Sign is: {{ $chineseSign }}</h4>
                        <h4>Today's fortune is: "{{ $fortune }}"</h4>
                        <h4>Your birthstone is:   <img src={{$birthstone}} alt="Birthstone"></h4>
                    </div>
                </section>
            </div>
        </div>
        <div class="column side">
            <a href='/'><img src='/images/cancer.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/leo.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/virgo.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/libra.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/scorpio.png' id='logo' alt='Birthday Info'></a>
            <a href='/'><img src='/images/sagittarius.png' id='logo' alt='Birthday Info'></a>
        </div>
    </div>

@endsection

