<?php
namespace DWA;

class DateInfo
{
    /**
     * Properties
     */
    private $request;
    public $hasErrors = false;
    public $month;
    public $day;
    public $year;
    public $minDay;
    public $maxDay;

    /**
     * Form constructor
     */
    public function __construct(array $request)
    {
        # Store form data (POST or GET) in a class property called $request
        $this->request = $request;
        $this->month = $request['month'];
        $this->day = $request['day'];
        $this->year = $request['year'];
        $this->minDay = 1;
    }

    /**
     * Returns true if *either* GET or POST have been submitted.
     */
    public function isSubmitted()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_GET);
    }

    /**
     * Get a value from the request, with the option of including a default
     * if the value is not set.
     */
    public function getMonth(string $month, string $default = null)
    {
        return $this->request['month'] ?? $default;
    }

    /**
     * Returns boolean as to whether a value is present in the request
     */
    public function hasMonth(string $month)
    {
        return isset($this->request['month']);
    }

    /**
     * Returns maxDay of the month
     */
    public function findMaxDay(string $month)
    {
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

        $this->maxDay = $daysInMonth[$this->month];

        return $this->maxDay;
    }

    public function getDay(string $day, string $default = null)
    {
        return $this->request['day'] ?? $default;
    }

    /**
     * Returns boolean as to whether a value is present in the request
     */
    public function hasDay(string $day)
    {
        return isset($this->request['day']);
    }

    public function getYear(string $year, string $default = null)
    {
        return $this->request['year'] ?? $default;
    }

    /**
     * Returns boolean as to whether a value is present in the request
     */
    public function hasYear(string $year)
    {
        return isset($this->request['year']);
    }

    /**
     *There are 30 leap years between 1900 and 2020:
     */
    public function isLeapYear(string $year)
    {
        $leapYears = [
            1904, 1908, 1912, 1916, 1920, 1924, 1928, 1932, 1936, 1940, 1944, 1948, 1952, 1956, 1960,
            1964, 1968, 1972, 1976, 1980, 1984, 1988, 1992, 1996, 2000, 2004, 2008, 2012, 2016, 2020
        ];
        foreach ($leapYears as $leapYear) {
            if ($leapYear == $this->year) {
                return true;
            }
        }

        return false;
    }
}
