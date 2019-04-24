## P3 Peer Review

+ Reviewer's name: Greg Retter
+ Reviwee's name: Victoria M.
+ URL to Reviewe's P3 Github Repo URL: *<https://github.com/royal0706/p3>*

*Answer the following questions in regards to the student's project you are reviewing. REMOVE THE INSTRUCTIONS FOR EACH PROMPT when complete. We should only see YOUR ANSWERS.*

## 1. Interface
Address as many of the following points as applicable:

+ Very simple interface, basic form with image all to the left side. Scrolls off the bottom when submitted so you can't see the answer.
+ The error notification for empty input is good.
+ Maybe adding some color and centering the form would make it more appealing. Also shrink the fonts to bring the answer up from the bottom.


## 2. Functional testing
One challenge of developing software is thinking of all the unexpected ways users might interact with our applications. It's easy to develop &ldquo;blinders&rdquo; to methods of interaction because we know so much about *how* our application works, and so we have a hard time imagining how our interfaces might be misinterpreted. Thus, it can be useful to have an outsider rigorously test our applications with the explicit intention of trying to break it.

Knowing this, it's time to put your reviewee's application to the test. Think of all the unexpected ways their application could be used with the intention of trying to produce some unexpected/undesirable outcome.

Examples...
+ The error notification for empty input seems to work well.
+ Error notification for all empty form cells and wrong input work. No instructions for input types.
+ Negative prices give negative results, destination only takes letters, but they don't have to make sense. Numeric inputs only take numbers, but will accept negatives.
+ Trying different URL add ons caused 404 error.  Only has one page that works on /trip/search.
+ The '/' route causes a 500 error.

__Summarize what you tried, and describe any unexpected/undesirable outcomes.__

(Even if you don't find any issues, having the reviewee see what you tried might give them insight into things they did not think to test.)

Destination accepts only alpha characters, but they can be gibberish or all 'Xs'.  No limit to the destination size.  Negative numbers are accepted and yield negative results. No limit to how big the number inputs can be. All inputs get saved to auto populate drop down and never clear, making a long list.  All inputs clear with the submit, so you don't remember your inputs for the answer you get.


## 3. Code: Routes
Skim through the student's code on Github.

Find their routes file (`routes/web.php`). Thinking about ideal Route/Controller organization&mdash; is there any code in this file that should be happening in a Controller? 

No, the routes refer to the controller.

## 4. Code: Views
Skim through the View files in `/resources/views` and address as many of the following points as applicable:

+ Yes, layout master is used.
+ Display code is separated from logic code.
+ Blade is used exclusively over php.
+ Standard Blade syntax is used.

## 5. Code: General
Address as many of the following points as applicable:

+ 
+ The code seems to follow the best practices from the class.
+ Yes, more comments would help.
+ The code is pretty straight forward.
+ No, the code seems pretty simple.

## 6. Misc
Good straight forward web page, but needs more style and input limits.