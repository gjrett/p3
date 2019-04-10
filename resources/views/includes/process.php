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

# Fortunes from http://www.fortunecookiemessage.com/archive.php?start=50

$fortunes = [
    0 => 'Jealousy does not open doors, it closes them!',
    1 => 'Today it is up to you to create the peacefulness you long for.',
    2 => 'A friend asks only for your time not your money.',
    3 => 'If you refuse to accept anything but the best, you very often get it.',
    4 => 'A smile is your passport into the hearts of others.',
    5 => 'A good way to keep healthy is to eat more Chinese food.',
    6 => 'Your high-minded principles spell success.',
    7 => 'Hard work pays off in the future, laziness pays off now.',
    8 => 'Change can hurt, but it leads a path to something better.',
    9 => 'Enjoy the good luck a companion brings you.',
    10 => 'Hidden in a valley beside an open stream- This will be the type of place where you will find your dream.',
    11 => 'A chance meeting opens new doors to success and friendship.',
    12 => 'You learn from your mistakes... You will learn a lot today.',
    13 => 'When fear hurts you, conquer it and defeat it!',
    14 => 'What ever you are goal is in life, embrace it visualize it, and for it will be yours.',
    15 => 'Your shoes will make you happy today.',
    16 => 'You cannot love life until you live the life you love.',
    17 => 'Be on the lookout for coming events; They cast their shadows beforehand.',
    18 => 'Land is always on the mind of a flying bird.',
    19 => 'The man or woman you desire feels the same about you.',
    20 => 'Meeting adversity well is the source of your strength.',
    21 => 'A dream you have will come true.',
    22 => 'Our deeds determine us, as much as we determine our deeds.',
    23 => 'Never give up. You are not a failure if you do not give up.',
    24 => 'You will become great if you believe in yourself.',
    25 => 'There is no greater pleasure than seeing your loved ones prosper.',
    26 => 'You will marry your lover.',
    27 => 'A very attractive person has a message for you.',
    28 => 'You already know the answer to the questions lingering inside your head.',
    29 => 'It is now, and in this world, that we must live.',
    30 => 'You must try, or hate yourself for not trying.',
    31 => 'You can make your own happiness.',
    32 => 'The greatest risk is not taking one.',
    33 => 'The love of your life is stepping into your planet this summer.',
    34 => 'Love can last a lifetime, if you want it to.',
    35 => 'Adversity is the parent of virtue.',
    36 => 'Serious trouble will bypass you.',
    37 => 'A short stranger will soon enter your life with blessings to share.',
    38 => 'Now is the time to try something new.',
    39 => 'Wealth awaits you very soon.',
    40 => 'If you feel you are right, stand firmly by your convictions.',
    41 => 'If winter comes, can spring be far behind?',
    42 => 'Keep your eye out for someone special.',
    43 => 'You are very talented in many ways.',
    44 => 'A stranger, is a friend you have not spoken to yet.',
    45 => 'A new voyage will fill your life with untold memories.',
    46 => 'You will travel to many exotic places in your lifetime.',
    47 => 'Your ability for accomplishment will follow with success.',
    48 => 'Nothing astonishes men so much as common sense and plain dealing.',
    49 => 'Its amazing how much good you can do if you dont care who gets the credit.'
];

$fortune = $fortunes[rand(0, 49)];

$chineseSigns = [
    1900 => 'Rat',
    1901 => 'Ox',
    1902 => 'Tiger',
    1903 => 'Rabbit',
    1904 => 'Dragon',
    1905 => 'Snake',
    1906 => 'Horse',
    1907 => 'Goat',
    1908 => 'Monkey',
    1909 => 'Rooster',
    1910 => 'Dog',
    1911 => 'Pig'
];
$yearTemp = $year;
While ($yearTemp >= 1912) {
    $yearTemp = $yearTemp - 12;
}
$chineseSign = $chineseSigns[$yearTemp];

$zodiacSign = '';
if ($month == 'January' && $day <= 19) {
    $zodiacSign = 'Capricorn';
}
if ($month == 'January' && $day > 19) {
    $zodiacSign = 'Aquarius';
}
if ($month == 'February' && $day <= 18) {
    $zodiacSign = 'Aquarius';
}
if ($month == 'February' && $day > 18) {
    $zodiacSign = 'Pisces';
}
if ($month == 'March' && $day <= 20) {
    $zodiacSign = 'Pisces';
}
if ($month == 'March' && $day > 20) {
    $zodiacSign = 'Aries';
}
if ($month == 'April' && $day <= 19) {
    $zodiacSign = 'Aries';
}
if ($month == 'April' && $day > 19) {
    $zodiacSign = 'Taurus';
}
if ($month == 'May' && $day <= 20) {
    $zodiacSign = 'Taurus';
}
if ($month == 'May' && $day > 20) {
    $zodiacSign = 'Gemini';
}
if ($month == 'June' && $day <= 20) {
    $zodiacSign = 'Gemini';
}
if ($month == 'June' && $day > 20) {
    $zodiacSign = 'Cancer';
}
if ($month == 'July' && $day <= 22) {
    $zodiacSign = 'Cancer';
}
if ($month == 'July' && $day > 22) {
    $zodiacSign = 'Leo';
}
if ($month == 'August' && $day <= 22) {
    $zodiacSign = 'Leo';
}
if ($month == 'August' && $day > 22) {
    $zodiacSign = 'Virgo';
}
if ($month == 'September' && $day <= 22) {
    $zodiacSign = 'Virgo';
}
if ($month == 'September' && $day > 22) {
    $zodiacSign = 'Libra';
}
if ($month == 'October' && $day <= 22) {
    $zodiacSign = 'Libra';
}
if ($month == 'October' && $day > 22) {
    $zodiacSign = 'Scorpio';
}
if ($month == 'November' && $day <= 21) {
    $zodiacSign = 'Scorpio';
}
if ($month == 'November' && $day > 21) {
    $zodiacSign = 'Sagittarius';
}
if ($month == 'December' && $day <= 21) {
    $zodiacSign = 'Sagittarius';
}
if ($month == 'December' && $day > 21) {
    $zodiacSign = 'Capricorn';
}

#Birth Stones
$birthstones = [
    'January' => 'Garnett.png',
    'February' => 'Amethyst,png',
    'March' => 'Aquamarine.png',
    'April' => 'Quartz/Diamond.png',
    'May' => 'Emerald.png',
    'June' => 'Pearl/Alexandrite.png',
    'July' => 'Ruby.png',
    'August' => 'Peridot.png',
    'September' => 'Sapphire.png',
    'October' => 'Tourmaline,png',
    'November' => 'Citrine.png',
    'December' => 'Turquoise.png'
];
$birthstone = '/images/' . $month . '.png';

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
    'birthday' => $birthday,
    'fortune' => $fortune,
    'zodiacSign' => $zodiacSign,
    'chineseSign' => $chineseSign,
    'birthstone' => $birthstone
];

# Redirect back to the form on show.blade.php
header('Location: show.blade.php');
#dump('results');
