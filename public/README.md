
*Any instructions/notes in italics should be removed from the template before submitting* 

# Project 2
+ By: Greg Retter
+ Production URL: <http://p2.dwa15gjr.me>

## Outside resources

Used foobooks0 project for all my file templates and changed according to my project needs

**HTML help**
stackoverflow.com
w3schools.com
html.com

**Week Day Finder Algorithm**

https://plus.maths.org/content/what-day-week-were-you-born

## 3 Unique inputs

1. *Dropdown to choose a month*
2. *Text inputs to indicate day number and year*
3. *Checkbox to indicate whether input date is a birthday*
4,  Regular and hidden display box

## Class
Form.php
DateInfo.php

## Code style divergences
None

## Notes for instructor
I received the free namescheap domain, so I switched my domain to dwa15gjr.me.  I set up some of my own changing erro messages as well as the validation from the Form class.  Besides some HTML configured limits, I set up PHP coded messages for all the inputs so that a red text message appears if left blank on submit.  I also set up the day input to write multiple error tests in the same spot and error proofed for all the months having 30 vs 31 days, and for February at 28 or 29 depending on leap years.  I admit to fighting with this code to figure out how to make it display the way I wanted, but that taught mr a lot. I didn't have enough time and I didn't want to risk breaking anything so I left my drop down menu in the verbose format instead of setting it up with an array.