@extends('layouts.master')

@section('title')
    {{ $results['birthdayTitle'] }}
@endsection

@section('head')
    {{-- Page specific CSS includes should be defined here; this .css file does not exist yet, but we can create it --}}
    <link href='/css/books/show.css' rel='stylesheet'>
@endsection

@section('content')

    <div align='center'>
        <div class=</div>
            <h1>Birthday Information</h1>
            <section id='main'>
                @if(count($results) == 0)
                    Input Error! No Birthday Information Available.
                @else
                    <h4>Birthday Title: {{ $results['birthdayTitle'] }}</h4>
                    <h4>Birthday date: {{ $results['birthDate'] }}</h4>
                    <h4>Week day born on: {{ $results['weekDay'] }}</h4>
                    <h4>Zodiac Sign: {{ $results['zodiacSign'] }}</h4>
                    <h4>Chinese Sign: {{ $results['chineseSign'] }}</h4>
                    <h4>Birthstone: <img src={{$results['birthstone']}} alt="Birthstone"></h4>
                    <!--if check box is checked, show the fortune.-->
                    @if ($results['checked'])
                        <h4>Your fortune: "{{ $results['fortune'] }}"</h4>
                    @endif
                @endif
            </section>
        </div>

@endsection

