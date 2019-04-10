<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class BirthdayController extends Controller
{

    /**
     * GET /birthday/
     */
    public function index()
    {
        return view('birthday.index');
    }

    /*
     * GET /birthdays/{birthday}
     */
    public function show(Request $request)
    {
        $birthdayTitle = $request->session()->get('birthdaytitle', '');
        $weekday = $request->session()->get('weekday', '');
        $zodiacSign = $request->session()->get('zodiacSign', '');
        $chineseSign = $request->session()->get('chineseSign', '');
        $fortune = $request->session()->get('fortune', '');
        $birthstone = $request->session()->get('birthstone', '');

        return view('birthday.show')->with([
            'birthdayTitle' => $birthdayTitle,
            'weekday' => $weekday,
            'zodiacSign' => $zodiacSign,
            'chineseSign' => $chineseSign,
            'fortune' => $fortune,
            'birthstone' => $birthstone
        ]);
    }

    /*
     * GET /books/search
     */
    public function search(Request $request)
    {
        $searchTerm = $request->session()->get('searchTerm', '');
        $caseSensitive = $request->session()->get('caseSensitive', false);
        $searchResults = $request->session()->get('searchResults', null);

        return view('books.search')->with([
            'searchTerm' => $searchTerm,
            'caseSensitive' => $caseSensitive,
            'searchResults' => $searchResults,
        ]);
    }

    public function searchProcess(Request $request)
    {
        $request->validate([
            'searchTerm' => 'required'
        ]);

        # Start with an empty array of search results; books that
        # match our search query will get added to this array
        $searchResults = [];

        # Store the searchTerm in a variable for easy access
        # The second parameter (null) is what the variable
        # will be set to *if* searchTerm is not in the request.
        $searchTerm = $request->input('searchTerm', null);

        # Only try and search *if* there's a searchTerm
        if ($searchTerm) {
            # Open the books.json data file
            # database_path() is a Laravel helper to get the path to the database folder
            # See https://laravel.com/docs/helpers for other path related helpers
            $booksRawData = file_get_contents(database_path('/books.json'));

            # Decode the book JSON data into an array
            # Nothing fancy here; just a built in PHP method
            $books = json_decode($booksRawData, true);

            # Loop through all the book data, looking for matches
            # This code was taken from v0 of foobooks we built earlier in the semester
            foreach ($books as $title => $book) {
                # Case sensitive boolean check for a match
                if ($request->has('caseSensitive')) {
                    $match = $title == $searchTerm;
                    # Case insensitive boolean check for a match
                } else {
                    $match = strtolower($title) == strtolower($searchTerm);
                }

                # If it was a match, add it to our results
                if ($match) {
                    $searchResults[$title] = $book;
                }
            }
        }

        # Redirect back to the search page w/ the searchTerm *and* searchResults (if any) stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
        return redirect('/books/search')->with([
            'searchTerm' => $searchTerm,
            'caseSensitive' => $request->has('caseSensitive'),
            'searchResults' => $searchResults
        ]);
    }

    /*
     * GET /birthdays/create
     */
    public function create()
    {
        return view('birthday.create');
    }

    public function process(Request $request)
    {
        # Validate the form data
        $request->validate([
            'birthdayTitle' => 'required',
            'month' => 'required',
            'day' => 'numeric|min:1|max:31',
            'year' => 'numeric|min:1900|max:2018'
        ]);
        # Note: If validation fails, it will redirect the visitor back to the form page
        # and none of the code that follows will execute.

        # Start with an empty array of search results; books that
        # match our search query will get added to this array
        $inputResults = [];

        $birthdayTitle = $request->input('birthdayTitle', null);
        $month = $request->input('month', null);
        $day = $request->input('day', null);
        $year = $request->input('year', null);
        $checked = $request->input('checked', null);

        #Get last day of the month to validate day is past month's end

        $daysInMonth = [
            'January' => 31,
            'February' => 28,
            'March' => 31,
            'April' => 30,
            'May' => 31,
            'June' => 30,
            'July' => 31,
            'August' => 31,
            'September' => 30,
            'October' => 31,
            'November' => 30,
            'December' => 31
        ];

        $maxDay = $daysInMonth[$month];

        # Check to see if it is a leap year and if the month is February
        # If so, add one to the max number of days

        $leapYears = [
            1904, 1908, 1912, 1916, 1920, 1924, 1928, 1932, 1936, 1940, 1944, 1948, 1952, 1956, 1960,
            1964, 1968, 1972, 1976, 1980, 1984, 1988, 1992, 1996, 2000, 2004, 2008, 2012, 2016, 2020
        ];
        $isLeapYear = false;
        foreach ($leapYears as $leapYear) {
            if ($leapYear == $year) {
                $isLeapYear = true;
            }
        }
        if (($month == 'February') && ($isLeapYear)) {
            $maxDay += 1;
        }
        if ($day > $maxDay) {
            # Redirect back to the input page wth an error
            # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
            return redirect('/birthdays/create')->with([$errors['day'] = "End of month exceeded"]);
        }

        #Derive date of birth from the input
        $birthDate = $month . '/' . $day . '/' . $year;

        #Begin calculation to find the day of the week for birthday
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
        #Randomly select a fortune from the 50 available
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

        $results = [
            'birthdayTitle' => $birthdayTitle,
            'birthDate' => $birthDate,
            'weekDay' => $weekDay,
            'checked' => $checked,
            'fortune' => $fortune,
            'zodiacSign' => $zodiacSign,
            'chineseSign' => $chineseSign,
            'birthstone' => $birthstone];

        # Redirect to the show page w/ the results stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data

        #return redirect('/birthdays/show')->with($results);

        return view('birthday.show')->with([
            'results' => $results,
        ]);
    }

    /*
     * POST /books
     */
    public function store(Request $request)
    {
        # Validate the request data
        $request->validate([
            'birthdayTitle' => 'required',
            'month' => 'required',
            'year' => 'required|digits:4',
            'day' => 'required|digits'
        ]);

        # Note: If validation fails, it will redirect the visitor back to the form page
        # and none of the code that follows will execute.

        # Code will eventually go here to add the book to the database,
        # but for now we'll just dump the form data to the page for proof of concept
        dump($request->all());
    }
}