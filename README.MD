# Chess code kata
This is my take on a given code kata. It took me about 5 hours (after getting a development environment set up on Windows 10, which may have involved some cursing) to write the implementation. As a  little bonus I made the grid size variable and created a presenter that can output the chess board with placed pieces as a table, like so:
```
+---+---+---+---+---+---+---+---+
|   | A | B | C | D | E | F | G |
+---+---+---+---+---+---+---+---+
| 1 | . | . | . | X | . | . | . |
| 2 | . | . | . | . | . | . | X |
| 3 | . | . | X | . | . | . | . |
| 4 | . | . | . | . | . | X | . |
| 5 | . | X | . | . | . | . | . |
| 6 | . | . | . | . | X | . | . |
| 7 | X | . | . | . | . | . | . |
+---+---+---+---+---+---+---+---+
```

## The assumptions
The assumptions are as follows:
- The assignment should take about 4 hours
- The chessboard has a grid size of 7 x 7 (I made this a variable for fun)
- The queen is the piece with the most freedom of movement. It can move both horizontally, vertically and diagonally and can cross any distance across the board

## The assignment
- Calculate at least one (but preferably all) grid setting where 7 queens are placed on the board, without any of those pieces being able to `take` one another.  
- Give an estimate on how many possible outcomes there are (I calculated all of them)

## How to run the calculations
I added a console command that will spawn the calculator process. This command has a couple of optional parameters
- `gridSize` (default 7): the size of the grid
- `startingPoint` (default empty): the point to start from. For instance "A2"
- `--prettyPrint`: Whether to print the outcome as a table or as a json string 

```
# Calculate all outcomes for grid of 7 x 7
php artisan chess:calculate --prettyPrint
```
```
# Calculate all outcomes for grid of 5 x 5
php artisan chess:calculate 5 --prettyPrint
```
```
# Calculate all outcomes for grid of 9 x 9, starting with "A1"
php artisan chess:calculate 9 A1
```

## Explanation of logic
So I realise that my solution is not the best and there probably is a genius out there that came up with a formula to calculate the amount of possible outcomes. The calculation process is painfully slow for instance, especially when increasing the grid size. However, I wanted this to be a true reflection of how I go about doing things so I came up with this, working from the following principles:  
- Once a queen is placed on a field. All other fields in that column are no longer selectable. This gave me the idea to just go from left to right and place a queen on every column.
- The queen can move both horizontally, vertically and diagonally. To make things easier, every time a queen is placed on a field, I go through the remaining columns and mark the fields that can no longer be selected as "invalid"
- This gives me the ability to fetch fields that are still selectable from the next column, and run the same process again, but with one of those fields added to the calculation. If the amount of points eventually equals the grid size, we found a valid outcome  

## What is missing?
I would have liked to add more tests. Especially the OutcomeCalculator, which is pretty much the most important class of this kata, is untested. However, I already spent 5 hours coming up with this solution and spending even more felt like cheating. 

Additionally, I would have wanted to create a queueable command for every calculation so multiple workers would have been able to do the calculations simultaneously, making the process a bit faster.
