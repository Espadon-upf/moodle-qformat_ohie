# moodle-qformat_ohie
A moodle plugin for a new qformat based on CSV  
This plugin is greatly inspired by the 'CSV format' plugin maintained by Gopal Sharma

-----------------

## General information

The **_"moodle-qformat_ohie"_**, allow you to import questions from a csv file for moodle.


-----------------
## Features
### Question name incrementation
You don't have to worry about the question name, it increments by itself.
It automatically adapts to the number of questions.
It will look like this:  
"Question [0-9]" if less than 10 questions in total  
"Question [0-9][0-9]" if between 10 and 100 questions in total  
"Question [0-9][0-9][0-9]" if between 100 and 999(inclusive) total  
**Warning:** If you wish to enter your own question names, it is advisable to do so for all questions.

### Allow negative point for multichoise with one right answer
You have the option of setting a negative point percentage for single answer multichoice questions.
Note that each question gets 1 point.  
If a question has 4 possible answers : 
- A
- B
- C
- D  

That the correct answer is 'A' and you have set 50% negative points.  
B,C and D are worth '**-0,5**'.

### Ponderation multichoice
For the multichoice with several right answers the calculation of the points is done in the following way:  
1. In the case of one wrong answer.  
Point per correct answer = 100 / number of correct answers  
Point for wrong answers = point for right answers

example 1:
- A => right | 50%
- B => right | 50%
- C => false |-50%

example 2: 
- A => right | 33,33%
- B => right | 33,33%
- C => false |-33,33%
- D => right | 33,33%
2. In the other cases:  
Point for right answers = 100 / number of right answers  
Point per wrong answers = 100 / (number of answers - point per right answers)

example 1:  
- A => right | 100%
- B => false |-50%
- C => false |-50%

example 2:  
- A => right | 50%
- B => right | 50%
- C => false |-50%
- D => false |-50%

example 3:  
- A => right | 33,33%
- B => right | 33,33%
- C => false |-50%
- D => false |-50%
- E => right | 33,33%

-----------------
## How to use it

### Requirements:

You will find in this git a .xlsx file.  
You only have to fill in the columns and export it in CSV format separated by semi-colons( ; )  
Required columns : 
- Type: select from the drop down menu your question type.
- Default mark: the total score for the question.
- Question text: the question statement
- Right(s) answer(s): the right answer(s) (see explanation below)



-----------------

## Types of Question

|Question Type 	|Keyword for Converter
|------------ |----------
|Multiple Choice one right answer 	|multichoice
|Multiple Choice all or nothing     |multichoice
|Multiple Choice multiple right answers |multichoiceset
|Short Answer 	|shortanswer
|Essay 	|essay
|True/False 	|truefalse
|Numerical 	|numerical

-----------------

## How to prepare a text file

1. Set question type
2. Define answer variants.

>multichoice (question type)  
>1.  Qui a le premier découvert la relation entre le chômage et l’inflation ?(number of the question(dot) question)  
>(Answer variants)  
>A.  Solow  
>B.  Samuelson  
>C.  Friedman  
>D.  Phillips  
>Answer:  D (Answer: Correct Answer)

-----------------

## Question Format Examples

#### Multiple choice

- One correct answer: 
  - without negative point:  
to see a gif <a href="gif/MultichoiceOneRightAnswer.gif"> click on me !</a>
  - with negative point:  
to see a gif <a href="gif/MultichoiceOneRightAnswerNegativPoint.gif"> click on me !</a>

- Multiple correct answers:  
to see a gif <a href="gif/MultichoiceAllOrNothing.gif"> click on me !</a>

- All Or Nothing:  
to see a gif <a href="gif/MultichoiceAllOrNothing.gif"> click on me !</a>

#### Short Answer
to see a gif <a href="gif/ShortAnswer.gif"> click on me !</a>

#### Essay
to see a gif <a href="gif/Essay.gif"> click on me !</a>

#### True/False
to see a gif <a href="gif/TrueFalse.gif"> click on me !</a>

#### Numerical
to see a gif <a href="gif/Numerical.gif"> click on me !</a>

-----------------

## Authors

| Last name     |    First name   |      role      
|  -----------  |   ------------  |    --------   
|   Appriou     |      Ronan      |   supervisor   
|   Giard       |      Kenan      | lead developer 

-----------------
## License
This program is under the GPL license see LICENSE.txt
