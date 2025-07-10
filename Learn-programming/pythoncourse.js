// List of topics with their respective day
const rawTopics = [
    "Introduction <br> Day 1", 
    "Variables <br> Day 2", 
    "Data Types <br> Day 3", 
    "Numbers <br> Day 4", 
    "Strings <br> Day 5",
    "Lists <br> Day 6", 
    "Tuples <br> Day 7", 
    "Dictionaries <br> Day 8", 
    "Sets <br> Day 9", 
    "Conditionals <br> Day 10",
    "While Loops Part 1 <br> Day 11", 
    "While Loops Part 2 <br> Day 12", 
    "For Loops Part 1 <br> Day 13", 
    "For Loops Part 2 <br> Day 14", 
    "Functions Part 1 <br> Day 15", 
    "Functions Part 2 <br> Day 16", 
    "Functions Part 3 <br> Day 17", 
    "Recursion Part 1 <br> Day 18", 
    "Recursion Part 2 <br> Day 19", 
    "Modules Part 1 <br> Day 20", 
    "Modules Part 2 <br> Day 21", 
    "Packages Part 1 <br> Day 22", 
    "Packages Part 2 <br> Day 23", 
    "File Handling Part 1 <br> Day 24", 
    "File Handling Part 2 <br> Day 25", 
    "Exceptions Part 1 <br> Day 26", 
    "Exceptions Part 2 <br> Day 27", 
    "Iterators Part 1 <br> Day 28", 
    "Iterators Part 2 <br> Day 29", 
    "Generators Part 1 <br> Day 30", 
    "Generators Part 2 <br> Day 31", 
    "Lambda Functions Part 1 <br> Day 32", 
    "Lambda Functions Part 2 <br> Day 33", 
    "Map, Filter, Reduce Part 1 <br> Day 34", 
    "Map, Filter, Reduce Part 2 <br> Day 35", 
    "Comprehensions Part 1 <br> Day 36", 
    "Comprehensions Part 2 <br> Day 37", 
    "Regular Expressions Part 1 <br> Day 38", 
    "Regular Expressions Part 2 <br> Day 39", 
    "Date and Time Part 1 <br> Day 40", 
    "Date and Time Part 2 <br> Day 41", 
    "Random Module Part 1 <br> Day 42", 
    "Random Module Part 2 <br> Day 43", 
    "Math Module Part 1 <br> Day 44", 
    "Math Module Part 2 <br> Day 45", 
    "OS Module Part 1 <br> Day 46", 
    "OS Module Part 2 <br> Day 47", 
    "Sys Module Part 1 <br> Day 48", 
    "Sys Module Part 2 <br> Day 49", 
    "JSON Part 1 <br> Day 50", 
    "JSON Part 2 <br> Day 51", 
    "CSV Part 1 <br> Day 52", 
    "CSV Part 2 <br> Day 53", 
    "XML Part 1 <br> Day 54", 
    "XML Part 2 <br> Day 55", 
    "SQLite Part 1 <br> Day 56", 
    "SQLite Part 2 <br> Day 57", 
    "Web Scraping Part 1 <br> Day 58", 
    "Web Scraping Part 2 <br> Day 59", 
    "Requests Part 1 <br> Day 60", 
    "Requests Part 2 <br> Day 61", 
    "Unit Testing Part 1 <br> Day 62", 
    "Unit Testing Part 2 <br> Day 63", 
    "Logging Part 1 <br> Day 64", 
    "Logging Part 2 <br> Day 65", 
    "Debugging Part 1 <br> Day 66", 
    "Debugging Part 2 <br> Day 67", 
    "Data Structures Part 1 <br> Day 68", 
    "Data Structures Part 2 <br> Day 69", 
    "Data Structures Part 3 <br> Day 70", 
    "Algorithms Part 1 <br> Day 71", 
    "Algorithms Part 2 <br> Day 72", 
    "Sorting Algorithms Part 1 <br> Day 73", 
    "Sorting Algorithms Part 2 <br> Day 74", 
    "Search Algorithms Part 1 <br> Day 75", 
    "Search Algorithms Part 2 <br> Day 76", 
    "OOP Principles Part 1 <br> Day 77", 
    "OOP Principles Part 2 <br> Day 78", 
    "OOP Principles Part 3 <br> Day 79", 
    "Classes and Objects Part 1 <br> Day 80", 
    "Classes and Objects Part 2 <br> Day 81", 
    "Inheritance Part 1 <br> Day 82", 
    "Inheritance Part 2 <br> Day 83", 
    "HTML Part 1 <br> Day 84", 
    "HTML Part 2 <br> Day 85", 
    "CSS Part 1 <br> Day 86", 
    "CSS Part 2 <br> Day 87", 
    "JavaScript Part 1 <br> Day 88", 
    "JavaScript Part 2 <br> Day 89", 
    "DOM Manipulation Part 1 <br> Day 90", 
    "DOM Manipulation Part 2 <br> Day 91", 
    "Bootstrap Part 1 <br> Day 92", 
    "Bootstrap Part 2 <br> Day 93", 
    "Git Part 1 <br> Day 94", 
    "Git Part 2 <br> Day 95", 
    "Docker Part 1 <br> Day 96", 
    "Docker Part 2 <br> Day 97", 
    "Cloud Computing Part 1 <br> Day 98", 
    "Cloud Computing Part 2 <br> Day 99", 
    "Cloud Computing Part 3 <br> Day 100"
];


// Clean topic names for display
const cleanTopics = rawTopics.map(topic => topic.split('<br>')[0].trim());

const contentAndCode = {
    "Introduction": {
        content: `
        <br>
<h2>Introduction to Python</h2>
<p>What is a Programming Language? <br> 
Computers do not understand human languages, so programs must be written in a language a computer can understand. 
There are hundreds of programming languages, developed to make the programming process easier for people.</p>

<p>Python: Python was created by Guido van Rossum in 1990.</p>
<ul>
    <li>Python is a high-level, interpreted programming language known for its simplicity and readability.</li>
    <li>Python is a general-purpose programming language. You can use Python to write code for any programming task.</li>
    <li>Python is interpreted, meaning Python code is translated and executed by an interpreter.</li>
    <li>Python is an Object-Oriented Programming (OOP) language. Data in Python are objects created from classes.</li>
    <li>The name "Python" was inspired by "Monty Python's Flying Circus," a comedy show on BBC.</li>
    <li>Python has a large developer community.</li>
    <li>It has a large number of libraries, packages, modules, and frameworks.</li>
</ul>

<p>Execute Python Syntax: Let’s get started by writing a simple Python program that displays the message “Welcome to Cybertron7”. 
To display a message in Python, use <code>print()</code></p>

<p><strong>Example 1:</strong> Printing “Hello, World!”</p>
<pre><code>print("Hello, World!")</code></pre>

<p><strong>Task 1:</strong> Print the output “Welcome to Cybertron7”</p>
<pre><code>print("Welcome to Cybertron7")</code></pre>

<p><b>Believe in consistency. Great things take time.</b></p>
        `,
        codeExamples: `
            <h3>Code Example:</h3>
            <pre><code>print("Welcome to Cybertron7")</code></pre>
        `
    },
    "Variables": {
        content: `
        <br>
<h1>Variables</h1>
<p>A variable is like a container that stores values. In Python, it is not necessary to declare the data type.</p>
<p>Variable is a name given to a memory location.</p>

<h2>Example:</h2>
<pre><code>a = "chim tapaku dum dum"</code></pre>

<h3>Explanation:</h3>
<p>In the above example, <b>a</b> is a variable that stores the string or sentence "chim tapaku dum dum". 
Python automatically understands that "a" is a string.</p>

<pre><code>b = 10</code></pre>
<p>In this example, "b" is a variable that stores the value of "10". Python automatically considers "b" as an integer.</p>

<strong>Let’s understand this simply:</strong>
<br>
<p>Let us assume a glass that contains water.</p>
<img src="pythonimg/variables-glass.png" alt="variables-glass" width="100px" height="auto">
<p>In this example, the glass is considered a variable, and water is considered a value or string.</p>
<p>Let us see this in coding:</p>
<pre><code>x = 5
y = 6
z = x + y
print("Sum of x and y:", z)
</code></pre>
<pre><code>Output:
Sum of x and y: 11</code></pre>
<p>In the above example, we stored 5 in the variable "x", 6 in the variable "y", and the sum of "x" and "y" is stored in the variable "z". By printing "z", we get the sum of x and y.</p>
<b>Example 2:</b>
<p>Let us see how to store a string in a variable:</p>
<pre><code>s = "chim tapaku dum dum"
print("Sentence:", s)</code></pre>
<p><b>Output:</b></p>
<pre><code>Sentence: chim tapaku dum dum</code></pre>
<p>In the above example, the sentence "chim tapaku dum dum" is stored in the variable "s". Instead of printing the string directly, we use the variable "s".</p>
<p><b>Note:</b> The values assigned to variables can be changed in the code.</p>
<pre><code>a = 10
print("Value of a:", a)  # Here the value of a is 10
a = 20
print("Value of a:", a)  # Now the value of a is 20</code></pre>
<p><b>Output:</b></p>
<pre><code>Value of a: 20</code></pre>
<h2>Rules for Python Variables:</h2>
<ul>
    <li>Python variables must start with a letter.</li>
    <p>Example:</p>
    <pre><code>a = 10
_b = 20
_name = "user"</code></pre>
    <li>Python variable names cannot start with a number.</li>
<pre><code>1name = 20  # (Not valid)
1_value = "user"  # (Not valid)</code></pre>
    <li>A Python variable name can only have alphanumeric characters and underscores.</li>
<pre><code>alpha (A-Z), alphanumeric (A-Z, 0-9), and underscore (_)</code></pre>
    <li>Python variable names are case-sensitive.</li>
    <pre><code>name = 10Name = "Cybertron7"</code></pre>
    <p>Here, "name" and "Name" are different because "n" is lowercase in "name", and "N" is uppercase in "Name". Python treats them as different variables.</p>
</ul>
        `,
        codeExamples: `
            <h3>Task:</h3>
<li> Create a variable "College" and assign your college name to the variable college and print it.</li>
<li>Create variable "a" , "b", "c" and assign 5 to variable "a", 10 to variable "b" and sum of a and b to variable "c" and print value of c.</p>
        `
    },
    
    "Data Types":{
        content:`
        <br>
        <h3><b>Data Types</b></h3>
        <p>Data types represents the kind of a value.</p>
        <p>Python language has multiple data types that you can use out of box, because they are built-in.</p>
        <p>Built-in means the data types that are built inside the language. Some of the basic data types are integer numbers, Strings, Characters, Bytes and Boolean.</p>
        <h3>1. Integer numbers:- </h3>
        <p>Integer numbers are represented by  “int”. It represents positive numbers, negative numbers and zero. </p>
        <h3>2. Floating-Point Numbers:-</h3>
        <p>Floating point numbers are the numbers which are represented with decimal points.</p>
        <h3>3. Complex Numbers:- </h3>
        <p>Complex numbers are the combination of both real and imaginary parts. It is in the form <b>a + bi</b>.</p>
        <h3>4. Strings and characters:- </h3>
        <p>Characters are the individual letters in a word. String is the combination of individual characters.</p>
        <h3>5. List:- </h3>
        <p>List is an ordered collection of items. They are mutable and they are defined by enclosing items in a square brackets “[ ]” .</p>
        <h3>6. Tuple:- </h3>
        <p>A tuple is an ordered collection of items. They are immutable and are defined by enclosing items in parenthesis “( )”.</p>
        <h3>7. Boolean :- </h3>
        <p>Boolean data types represents only two values (“True” ,”False”). It is commonly used in programming language to make a decision and to control the flow of execution.</p>
      <table border="1">
  <thead>
    <tr>
      <th>Example</th>
      <th>Data Type</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>x = "hello world"</td>
      <td>str</td>
    </tr>
    <tr>
      <td>x = 10</td>
      <td>int</td>
    </tr>
    <tr>
      <td>x = 10.5</td>
      <td>float</td>
    </tr>
    <tr>
      <td>x = 4j</td>
      <td>complex</td>
    </tr>
    <tr>
      <td>x = ["Rama", "Sita", "cherry"]</td>
      <td>list</td>
    </tr>
    <tr>
      <td>x = ("Rama", "Sita", "cherry")</td>
      <td>tuple</td>
    </tr>
    <tr>
      <td>x = range(6)</td>
      <td>range</td>
    </tr>
    <tr>
      <td>x = {"name" : "John", "age" : 36}</td>
      <td>dict</td>
    </tr>
    <tr>
      <td>x = {"Ram", "Sita", "cherry"}</td>
      <td>set</td>
    </tr>
    <tr>
      <td>x = frozenset({"apple", "banana"})</td>
      <td>frozenset</td>
    </tr>
    <tr>
      <td>x = True</td>
      <td>bool</td>
    </tr>
  </tbody>
</table>
        <h2><b>Getting the Data Type:-</b></h2>
        <p>You can get the data type of any object by using the type() function:</p>
        <h3>Example :</h3>
        <pre><code>x=10
print(type(x))</code></pre>
        <h3>Output :</h3>
        <p><b>class 'int'</b></p>
        <pre><code>x=”Cybertron7”
print(type(x))</code></pre>
        <h3>Output:</h3>
        <pre><code>class 'str'></code></pre>
         `,
              codeExamples: `
    <h2><b>Task:</b></h2>
        <h3>Create a variable named <b>my_var</b> and assign values of each data type. Also, print the data type using the type class.</h3>
        `
    },
     "Strings":{
        content:`
        <br>
        <h2><b>Strings</b></h2>
        <p>String is nothing but collection of characters (or) group of characters . 
            For example, "hello" is a string containing a sequence of characters 'h','e','l','l', and'o'.</p>
        <h3>Example 1 : "Python"</h3>
        <li>'P' is a character</li>
        <li>'y' is a character</li>
        <li>'t' is a character</li>
        <li>'h' is a character</li>
        <li>'o' is a character</li>
        <li>'n' is a character</li>
        <p>
            Python is a string because all the characters are grouped here to form a word
        </p>
        <h3><b>How to represent a String?</b></h3>
        <p>There are many ways to represent a string</p>
        <li>Single quotes   (' ') </li>
        <li>Double quotes   (" ") </li>
        <li>Triple quotes   ("' '")</li>
        <h3><b>Example 2 :</b></h3>
        <pre><code>singleQutes = 'I am Learning Python in Cybertron7' <br>
doubleQuotes = "I am Learning Python in Cybertron7"  <br>
tripleQuotes = "'I am Learning Python in Cybertron7 '"  <br> 
print(single) <br>
print(double) <br>
print(Triple)</code></pre>
        <h3><b>Output :</b></h3>
        <p> I am Learning Python in Cybertron7 </p>
        <p> I am Learning Python in Cybertron7 </p>
        <p> I am Learning Python in Cybertron7 </p>
        <h2><b>Methods In String: </b></h2> 
        <h3><b> 1. Lower() </b></h3>
        <p>This method is used to print a String in Lower case </p>
        <h3>Example</h3>
        <pre><code>a="Hello Programmer"<br>print(a.lower())</code></pre>
        <h3>Output : </h3>
        <p>Hello Programmer</p>
        <h3>Explanation :</h3>
        <p>In orginal string we have given H and P as capital Letter by using Lower function we can print every letter in a lower case. </p>
        <h3><b> 2. Upper() </b></h3>
        <p>This method is Used to print a word or string in upper case</p>
        <h3><b>Example : </b></h3>
        <pre><code>a="Welcome To Cybertron7"<br>print(a.upper())</code></pre>
        <h3>Output : </h3>
        <p>Welcome To Cybertron7</p>
        <h3> Explanation :</h3>
        <p>All the characters in the string was changed into capital letters by using the upper method</p>
        <h3><b> 3. Ends with() </b></h3>
        <p>This method is used to know whether the String is ending with specific word/words or not</p>
        <h3><b>Example : </b></h3>
        <pre><code>a="Consistency makes You Perfect" <br>print(a.endswith("ect"))</code> </pre>
        <h3>Output : </h3>
        <p>True</p>
        <h3> Explanation :</h3>
        <p>This method gives true for the above example because the given String is ending With "ect" they both are matching So the output is <b>True </b> or if they were not matched means it will print the output as <b>false</b> </p>
        <h3><b> 4.Starts with() </b></h3>
        <p>Used to Know whether a String starts With specific word or characters</p>
        <h3><b>Example : </b></h3>
        <pre><code>a="Learn Python" <br>print(a.Startswith("Le"))</code> </pre>
        <h3>Output : </h3>
        <p>True</p>
        <h3><b> 5.Replace() </b></h3>
        <p>This method is used to replace a character or word with new one</p>
        <h3><b>Example : </b></h3>
        <pre><code>a="Learn Py"<br>print(a.replace("Py","Python"))</code></pre>
        <h3>Output : </h3>
        <p>Learn Python</p>
        <h3> Explanation :</h3>
        <p>In this example we are replacing "Py" to "Python" by using replace method</p>
        <h3><b> 6.Split() </b></h3>
        <p>This method is used to change the String into list</p>
        <h3><b>Example : </b></h3>
        <pre><code>a="Hello India"<br>print(a.split())</code></pre>
        <h3>Output : </h3>
        <p>['Hello','India']</p>
        <h3><b> 7.Count() </b></h3>
        <p>It is used for caluculate the number of times the specific letter repeated in the String .</p>
        <h3><b>Example : </b></h3>
        <pre><code>a="Hello India"<br>print(a.count("l"))</code></pre>
        <h3>Output : </h3>
        <p>2</p>
        <h3> Explanation :</h3>
        <p>Here "l" is present 2 Times in the string "Hello India"</p>
        <h3><b> 8.Split() </b></h3>
        <p>This method is used to trim/remove the empty space in a Sring</p>
        <h3><b>Example : </b></h3>
        <pre><code>a="     abc     " <br>print(a.strip())</code></pre>
        <h3>Output : </h3>
        <p>abc</p>
        <h3>Explanation :</h3>
        <p>It removes the empty spaces on both sides of "abc"</p>
        <p>They are two types in this method</p>
        <li>L Strip : remove empty space on left side</li>
        <li>R strip : remove empty space on right side</li>
        <h3>Note :</h3>
        <p>In string empty space is also countable</p>
        <h3><b> 9.len() </b></h3>
        <p>This method is used to find the lenght of a string</p>
        <h3><b>Example : </b></h3>
        <pre><code>a="Hello India"<br>print(len(a))</code> </pre>
        <h3>Output : </h3>
        <p>11</p>
        <h3> Explanation :</h3>
        <p>In the above string "Hello India" there are 11 characters ("H" "e" "l" "l" "0" "&nbsp" "I" "n" "d" "i" "a")</p>
        <p>! Here Empty Space Also be Counted</p>

        `,
              codeExamples: `
   <h2><b>Tasks</b></h2>
        <h3>Practice The String Methods On String a="Practice makes man perfect"</h3>
        <li>1 . Change the all Letters Into<b> lower case</b>?</li>
        <li>2 . Change the all Letters Into <b>Upper case</b>?</li>
        <li>3 . Check Whether The ending word is ends with "ect"?</li>
        <li>4 . Check the <b>StartsWith function</b> with "Pra"? </li>
        <li>5 . Make the given string into single words?</li>
        <li>6 . Count the number of times letter "e" is in the string </li>
        <li>7 . Find the Length of the Given String "a"</li>
        `
    },
    
    "Numbers": {
    content: `
    <br>
    <h3>Numbers</h3>
    <strong>Numerical representation of a value is called Number</strong>
    <p>In Python, there are three main types of numbers</p>
    <p>1. Integer</p>
    <p>2. Float</p>
    <p>3. Complex</p>

    <h3>1. Integer</h3>
    <p>Integers are whole numbers, including both positive and negative numbers, but they do not include fractions or decimals.</p>
    <h3>Example:</h3>
    <pre><code>num = 8
print(num)
print(type(num))
</code></pre>
    <h3>Output:</h3>
    <p>8</p>
    <p>&lt;class 'int'&gt;</p>
    <h3>2. Float</h3>
    <p>Floating-point numbers are numbers that contain one or more decimal points. They can be positive or negative.</p>
    <h3>Example:</h3>
    <pre><code>num1 = 8.6
num2 = -8.6
print(type(num1))
print(type(num2))
</code></pre>
    <h3>Output:</h3>
    <p>&lt;class 'float'&gt;</p>
    <p>&lt;class 'float'&gt;</p>

    <h3>3. Complex Number</h3>
    <p>A complex number consists of both a real part and an imaginary part. It is represented in the form "a + bj", where 'a' is the real part and 'b' is the imaginary part.</p>
    <h3>Example:</h3>
    <pre><code>num1 = 2 + 3j
print(num1)
print(type(num1))
</code></pre>
    <h3>Output:</h3>
    <p>2+3j</p>
    <p>&lt;class 'complex'&gt;</p>

    <h3>Type Conversion</h3>
    <p>Type conversion is the process of converting one type of number to another. Python provides built-in functions to perform these conversions.</p>

    <h3>Example 1:</h3>
    <pre><code>a = 2
print(float(a))
print(complex(a))
</code></pre>
    <h3>Output:</h3>
    <p>2.0</p>
    <p>(2+0j)</p>

    <h3>Example 2:</h3>
    <pre><code>a = 2.5
print(int(a))
</code></pre>
    <h3>Output:</h3>
    <p>2</p>
    <h3>Additional Notes:</h3>
    <ul>
        <li><strong>Note 1:</strong> While converting a float to an integer, Python removes the deciaml part.</li>
        <li><strong>Note 2:</strong> Complex numbers cannot be directly converted to integers or floats. Attempting to do so will result in a TypeError.</li>
    </ul>`,
     codeExamples: `
    <h3>Tasks</h3>
    <ul>
        <li>Convert an integer to a float and a complex number. Print the results.</li>
        <li>Convert a float to an integer. What happens to the decimal part?</li>
        <li>Experiment with converting complex numbers to other types. Observe the output.</li>
    </ul>`
    },
    "Lists":{
        content:`
        
    <h1>Lists</h1>
    <ul>
        <li>Lists are used to store more than one element in a single variable.</li><br>
        <li>They are represented with square brackets "[]".</li><br>
        <li>Lists are mutable data types, which means we can modify them.</li><br>
        <li>Lists can store different types of data, including integers, floats, strings, and booleans e.t.c.</li><br>
        <li>Lists allow duplicate entries.</li><br>
        <li>They support indexing, which allows access to elements by their position in the list.</li><br>
        <li>Lists maintain the order of elements as they are inserted.</li><br>
        <li>You can use slicing to access a range of elements within a list.</li><br>
        <li>Lists can be nested, means a list can contain other lists as elements.</li><br>
        <li>Common operations in lists are adding, removing, and modifying elements.</li><br>
        <li>Methods like append(), extend(), remove(), and pop() are commonly used to manipulate lists.</li><br>
        <li>Lists can be iterated over using loops, such as for loops.</li><br>
        <li>Lists are dynamic, meaning they can grow and shrink in size as needed.</li><br>
        <li>Lists are a fundamental data structure in Python, used for various purposes like storing collections of items, iterating through sequences, and more.</li><br>
        <li>Accessing elements by index is straightforward: my_list[0] returns the first element.</li><br>
        <li>Use slicing to access parts of a list: my_list[1:3] returns the second and third elements.</li>
    </ul>
    <div class="container">
        <div id="python-code">
            <span id="variable-declaration">my_list = [</span>
            <span id="list-elements"></span>
            <span id="closing-bracket">]</span>
        </div>
    </div>
    <h1>Indexing:</h1>
    <p>Indexing is a way to access elements in a list by their position. <br> Python
        uses zero-based indexing, meaning the first element is at index 0, the second element is at
        index 1, and so on.</p>
        <div class="box">
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
        </div>
        <div class="forward-indexing">
            <h2>Forward Indexing:</h2>
            <p>In Forward indexing starts at 0. This means the index of each element in a list is:</p>
            <ul>
                <li>Index 0: 1</li>
                <li>Index 1: 2</li>
                <li>Index 2: 3</li>
                <li>Index 3: 4</li>
                <li>Index 4: 5</li>
            </ul>
        </div>
        <div class="backward-indexing">
            <h2>Backward Indexing:</h2>
            <p>In Backward Indexing starts at -1. This means the index of each element in a list is:</p>
            <ul>
                <li>Index -1: 5</li>
                <li>Index -2: 4</li>
                <li>Index -3: 3</li>
                <li>Index -4: 2</li>
                <li>Index -5: 1</li>
            </ul>
        </div>
        <p>Indexing is nothing but location of a particular element in list.</p>
        <h3>Example:</h3>
        a=[] //Defing list
        <pre><code>a=[1,1.2,'Cybertron7',2024]
print(a[2])
print(a[-1])</code></pre>
        <h3>Output: </h3>
<pre><code>Cybertron7
2024</code></pre>
        <p>Here the above example at index Cybertron7 is present at 2 so, it prints the string of "Cybertron7"</p>
        <h3>Slicing</h3>
        <p>Slicing is a feature in python which allows us to extract subset of data from list</p>
        <p>We can use slicing to extract subset of data from list</p>
        <p>Structure:[S(start):E(End):P(Pass)]</p>
        <p>start: it is the starting index of the slice</p>
        <p>end: it is the ending index of the slice</p>
        <p>pass: it is the step size of the slice</p>
        <h2>Example:</h2>
        <pre><code>new_list=[1,2,3,4,'cybertron7','coding']
print(new_list[0:4:2])</code></pre>
    <h3>Output:</h3>
    <pre><code>1,3</code></pre>
    <p>Here the above example starts at 0 (start),4(Ends) by skipping 2 number. </p>
        <h4>Operations can be performed:</h4>
        <ul>
            <li>append</li>
            <li>extend</li>
            <li>count</li>
            <li>insert</li>
            <li>pop</li>
            <li>remove</li>
            <li>index</li>
        </ul>
        <h3>Append</h3>
<pre><code>a=[1,2,3,4,5]
a.append(6)
print(a)</code></pre>
        <h3>Output:</h3>
        <pre><code>[1, 2, 3, 4, 5, 6]</code></pre>
        <p>Here the above example appends 6 at the end of the list</p>
        <h3>Extend</h3>
        <pre><code>a=[1,2,3,4,5]
a.extend([6,7,8])
print(a)</code></pre>
        <h3>Output:</h3>
        <pre><code>[1, 2, 3, 4, 5, 6]</code></pre>
        <p>Here the above example extends the list with [6,7,8]</p>
        <h3>Count</h3>
        <pre><code>a=[1,2,3,4,5,5,7,8,9]
print(a.count(5))</code></pre>
        <h3>Output:</h3>
        <pre><code>2</code></pre>
        <p>Here the above example counts the number of times 5 occurs in the list</p>
        <h3>Remove</h3>
        <pre><code>a=[1,2,3,4,5,5,7,8,9]
a.remove(5)
print(a)</code></pre>
        <h3>Output:</h3>
        <pre><code>[1, 2, 3, 4, 5, 7, 8, 9]</code></pre>
        <p>Here the above example removes the first occurrence of 5 in the list</p>
        <h3>Pop</h3>
        <pre><code>a=[1,2,3,4,5,5,7,8,9]
print(a.pop())</code></pre>
        <h3>output:</h3>
        <pre><code>9</code></pre>
        <p>Here the above example removes the last element from the list</p>
        <h3>Index</h3>
        <pre><code>a=[1,2,3,4,5,6,7,8,9]
print(a.index(5))</code></pre>
        <h3>Output</h3>
        <pre><code>4</code></pre>
        <p>#Here the above example returns the index of the first occurrence of 5 in the
            list</p>
        `,
        codeExamples: `
        <h3>Task</h3>
        <p>Create a list and perform append,pop and remove</p>
        `
    },
   "Tuples": {
       content:
    `<h1>Tuples</h1>
    <p>Tuples allow you to store different types of elements like integers, strings, and booleans.</p>
    <p>A tuple is denoted by parentheses "()"</p>
    <p>It also allows indexing and slicing, just like a list.</p>
    <p>A tuple is also immutable.</p>
    <p>Tuples do not have any specific methods, but they can use built-in methods.</p>
    <h2>Example 1:</h2>
    <pre><code>a = (1, 2, 3, 4, "Hello", True)
print(a)</code></pre>
    <p><strong>Output:</strong></p>
    <pre><code>(1, 2, 3, 4, 'Hello', True)</code></pre>
    <h2>Example 2:</h2>
    <pre><code>print(type(a))</code></pre>
    <p><strong>Output:</strong></p>
    <pre><code>&lt;class 'tuple'&gt;</code></pre>
    <h1>Operations on Tuples:</h1>
    <ul>
        <li>Concatenation</li>
        <li>Iteration</li>
        <li>Repetition</li>
    </ul>
    <h2>Concatenation:</h2>
    <p>Concatenation means adding two tuples together.</p>
    <h3>Example:</h3>
    <pre><code>tuple1 = (1, 2, 3)
tuple2 = (4, 5, 6)
print(tuple1 + tuple2)</code></pre>
    <p><h3>Output:</h3></p>
    <pre><code>(1, 2, 3, 4, 5, 6)</code></pre>
    <h2>Iteration:</h2>
    <p>Iteration is the process of looping through the elements in a tuple.</p>
    <h3>Example:</h3>
    <pre><code>tuple = (1, 2, 3, 4, 5, 6)
for i in tuple:
    print(i)</code></pre>
    <p><h3>Output:</h3></p>
    <pre><code>1
2
3
4
5
6</code></pre>
    <h2>Repetition:</h2>
    <p>Repetition means repeating the elements of a tuple.</p>
    <h3>Example:</h3>
    <pre><code>tuple = (1, 2, 3)
print(tuple * 3)</code></pre>
    <p><h3>Output:</h3></p>
    <pre><code>(1, 2, 3, 1, 2, 3, 1, 2, 3)</code></pre>
    <h1>Built-in Functions for Tuples:</h1>
    <h2>min()</h2>
    <p>Finds the minimum value in a tuple.</p>
    <h3>Example:</h3>
    <pre><code>tuple = (1, 2, 3, 4, 5, 6)
print(min(tuple))</code></pre>
    <p><h3>Output:</h3></p>
    <pre><code>1</code></pre>
    <h2>max()</h2>
    <p>Finds the maximum value in a tuple.</p>
    <h3>Example:</h3>
    <pre><code>tuple = (1, 2, 3, 4, 5, 6)
print(max(tuple))</code></pre>
    <p><h3>Output:</h3></p>
    <pre><code>6</code></pre>
    <h2>sum()</h2>
    <p>Calculates the sum of all values in a tuple.</p>
    <h3>Example:</h3>
    <pre><code>tuple = (1, 2, 3, 4, 5, 6)
print(sum(tuple))
</code></pre>
<p><h3>Output:</h3></p>
<pre><code>21</code></pre>
    <h2>len()</h2>
    <p>Finds the length of a tuple.</p>
    <h3>Example:</h3>
    <pre><code>tuple = (1, 2, 3, 4, 5, 6)
print(len(tuple))</code></pre>
    <p><h3>Output:</h3></p>
    <pre>6</pre>
    <h1>Membership:</h1>
    <h2>in</h2>
    <p>Checks if a value is present in a tuple.</p>
    <h3>Example:</h3>
    <pre><code>tuple = (1, 2, 3, 4, 5, 6)
print(1 in tuple)</code></pre>
    <p><strong>Output:</strong></p>
    <pre><code>True</code></pre>
    <h2>not in</h2>
    <p>Checks if a value is not present in a tuple.</p>
    <h3>Example:</h3>
    <pre><code>tuple = (1, 2, 3, 4, 5, 6)
print(7 not in tuple)</code></pre>
    <p><h3>Output:</h3></p>
    <pre><code>True</code></pre>`,
    codeExamples: `
    <h1>Tasks</h1>
    <ul>
        <li>Create a tuple of your three favorite fruits. Print the tuple and then try to change one of the fruits. What happens?</li>
        <li>Concatenate two tuples: one with numbers and another with colors. Print the result. What do you get?</li>
        <li>Use a loop to print all the elements of a tuple that contains the names of your friends.</li>
        <li>Multiply a tuple of your favorite numbers by 3. What do you notice in the output?</li>
        <li>Check if your favorite number is in a tuple of random numbers. If it is, print "Hooray!" Otherwise, print "Oh no!"</li>
    </ul>`
},
"Dictionaries":{
content:`  <h1><b>Dictionary</b></h1>
    <p>A dictionary is a data structure used to store values in the form of <b>"Key: Value"</b> pairs.</p>
    <p>It is different from lists, tuples, and arrays because each key in a dictionary has an associated value.</p>
    <p>Dictionaries are defined by curly braces <b>{ }</b>, and the elements are separated by commas <b>(,)</b>.</p>
    <p>The keys in dictionaries are immutable (cannot be changed), but the values associated with the keys are mutable (can be changed).</p>
    <h2>Example:</h2>
    <pre><code>dict = { 'a': 123, 'b': "Hello India"}
#         |      |
#    dictionary key  value</code></pre>
    <p>Note: The keys in a dictionary must be unique.</p>
    <p>Dictionaries do not support slicing operations like lists or tuples.</p>
    <h2><u>Methods:</u></h2>
    <h3><b>1. get( )</b></h3>
    <p>It is used to retrieve the value associated with a specific key in the dictionary.</p>
    <h3><b>Example:</b></h3>
    <pre><code>d = {1: 'cybertron7', 2: 'Arey entra idi'}
print(d.get(2))</code></pre>
    <h3>Output:</h3>
    <pre><code>Arey entra idi</code></pre>
    <h3><b>2. update( )</b></h3>
    <p>This method is used to change or add new key-value pairs to the dictionary.</p>
    <h3><b>Example:</b></h3>
    <pre><code>d = {1: 'cybertron7', 2: 'Arey entra idi'}
d.update({3: 'Learner'})
print(d)</code></pre>
    <h3>Output:</h3>
    <pre><code>{1: 'cybertron7', 2: 'Arey entra idi', 3: 'Learner'}</code></pre>
    <h3><b>3. values( )</b></h3>
    <p>This method is used to extract all the values in a dictionary.</p>
    <h3><b>Example:</b></h3>
    <pre><code>d = {1: 'value', 2: 'you are', 'python': 'Learning'}
print(d.values())</code></pre>
    <h3>Output:</h3>
    <pre><code>['value', 'you are', 'Learning']</code></pre>
    <h3><b>4. keys( )</b></h3>
    <p>This method is used to extract all the keys in a dictionary.</p>
    <h3><b>Example:</b></h3>
    <pre><code>d = {1: 'cybertron7', 2: 'Arey entra idi', 'python': 7}
print(d.keys())</code></pre>
    <h3>Output:</h3>
    <pre><code>[1, 2, 'python']</code></pre>
    <h3><b>5. items( )</b></h3>
    <p>This method is used to extract both the keys and values as pairs in a dictionary.</p>
    <h3><b>Example:</b></h3>
    <pre><code>d = {1: 'learning', 2: 'python', 'Easy': 3}
print(d.items())</code></pre>
    <h3>Output:</h3>
    <pre><code>[(1, 'learning'), (2, 'python'), ('Easy', 3)]</code></pre>
    <p>// This will give you all the key-value pairs in the dictionary.</p>
`,
codeExamples:` <h2><u>Tasks</u></h2>
    <ul>
        <li>Create a dictionary with 5 different key-value pairs and print it.</li>
        <li>Use the <b>get( )</b> method to retrieve the value of a specific key from your dictionary.</li>
        <li>Update your dictionary by adding a new key-value pair using the <b>update( )</b> method.</li>
        <li>Extract and print all the keys and values from your dictionary using the <b>keys( )</b> and <b>values( )</b> methods.</li>
    </ul>`
},
"Sets":{
    content :`
    <h1>Sets:</h1>
    <ul>
        <li>Sets is a data type in python used to store values like integers, floats, and strings.</li>
        <li>A set is defined using curly braces <b>({ })</b>.</li>
        <li>Sets do not allow duplicate values.</li>
        <li>Sets don't have indexing like lists.</li>
        <li>Since sets don't support indexing, slicing is also not possible.</li>
        <li>The elements in a set are unordered, meaning they are not arranged in any specific order.</li>
    </ul>
    <h2><b>Example:</b></h2>
    <p>A set is like a classroom full of different students. The classroom is the set, and the students are the elements.</p>
    <pre><code>b = {1, 2, 3.4, "cybertron7"} </code></pre>
    <p>Here, <b>b</b> is a set containing integer, float, and string values.</p>
    <h1><b>Set Methods:</b></h1>
    <h3><b>1. add()</b></h3>
    <p>This method is used to add an element to a set.</p>
    <p><b>Example:</b></p>
    <pre><code>S = {1, 2, 3, 4, 5} 
S.add(10)
print(S)</code></pre>
    <h3>Output:</h3>
    <p>{1, 2, 3, 4, 5, 10}</p>
    <h3><b>2. update()</b></h3>
    <p>This method allows adding multiple elements to a set.</p>
    <p><b>Example:</b></p>
    <pre><code>S = {1, 2, 3, 4} 
S.update([5, 6, 7])
print(S)</code></pre>
    <h3>Output:</h3>
    <p>{1, 2, 3, 4, 5, 6, 7}</p>
    <h3><b>3. pop()</b></h3>
    <p>This method randomly removes an element from the set.</p>
    <p><b>Example:</b></p>
    <pre><code>S = {0, 1, 2, 3, 5, 10} 
S.pop()
print(S)</code></pre>
    <h3>Output:</h3>
    <p>{1, 2, 3, 5, 10}</p>
    <h3><b>4. remove()</b></h3>
    <p>This method removes a specific element from a set.</p>
    <p><b>Example:</b></p>
    <pre><code>S = {5, 10, 20, 1, 2, 3} 
S.remove(10)
print(S)</code></pre>
    <h3>Output:</h3>
    <p>{5, 20, 1, 2, 3}</p>
    <h1><b>Set Operations:</b></h1>
    <h3><b>1. union()</b></h3>
    <p>This method is used to combine two sets.</p>
    <p><b>Example:</b></p>
    <pre><code>S1 = {1, 2, 3} 
S2 = {4, 5, 6}
print(S1.union(S2))</code></pre>
    <h3>Output:</h3>
    <p>{1, 2, 3, 4, 5, 6}</p>
    <h3><b>2. intersection()</b></h3>
    <p>This method returns the common elements between two sets.</p>
    <p><b>Example:</b></p>
    <pre><code>S1 = {1, 2, 3} 
S2 = {3, 4, 5, 6}
print(S1.intersection(S2))</code></pre>
    <h3>Output:</h3>
    <p>{3}</p>
    <h3><b>3. difference()</b></h3>
    <p>This method returns the elements that are present in the first set but not in the second.</p>
    <p><b>Example:</b></p>
    <pre><code>S1 = {1, 2, 3, 4, 5} 
S2 = {3, 4, 5, 6}
print(S1.difference(S2))</code></pre>
    <h3>Output:</h3>
    <p>{1, 2}</p>
    <h3><b>4. issubset()</b></h3>
    <p>Returns <b>True</b> if the second set is a subset of the first, otherwise <b>False</b>.</p>
    <p><b>Example:</b></p>
    <pre><code>S1 = {1, 2, 3, 4, 5, 6} 
S2 = {1, 2, 3}
print(S2.issubset(S1))</code></pre>
    <h3>Output:</h3>
    <p>True</p>
    <h3><b>5. issuperset()</b></h3>
    <p>Returns <b>True</b> if the first set contains all elements of the second set, otherwise <b>False</b>.</p>
    <p><b>Example:</b></p>
    <pre><code>S1 = {1, 2, 3, 4, 5, 10, 30, 40, 90} 
S2 = {2, 10, 30, 40}
print(S1.issuperset(S2))</code></pre>
    <h3>Output:</h3>
    <p>True</p>
    <h2><b>Note:</b></h2>
    <p>In the <b>issubset()</b> operation, if the elements in the second set are in the same order as in the first set, it returns <b>True</b>, otherwise <b>False</b>. In <b>issuperset()</b>, order doesn't matter.</p>
`,
codeExamples:`
<h1><b>Tasks</b></h1>
    <ul>
        <li>Create a set of your favorite snacks, then try to convince Python that adding "more pizza" isn't a duplicate!</li>
        <li>Make a set of your top 5 superhero powers. Try using pop() and see which power the universe decides to take away from you!</li>
        <li>Create a set of random household objects. Now use update() to throw in some imaginary ones—who says you can't have a flying carpet at home?</li>
    </ul>`
}, 
"Conditionals":{
    content:`
    <h1>Conditionals</h1>
<p>
    Sometimes we want to play cricket if the day is Sunday.<br>
    Sometimes we order Ice cream online if the day is sunny.<br>
    Sometimes we go for a trip if our parents allow.<br>
    All these are decisions that depend on a condition being met.<br>
    In Python programming too, we must be able to execute instructions when a condition is met. This is what conditionals are for!<br>
</p>
<h4>Syntax</h4>
<pre><code>if condition:
    # execute code block</code></pre>
<h4>Example</h4>
<pre><code>a = 33
b = 200
if b > a:
    print("b is greater than a")</code></pre>
<h3>if-else Statement</h3>
<p>
    The if statement executes the code block when the condition is true.<br>
    The else statement works with the if statement to execute a code block when the defined if condition is false.
</p>
<h4>Syntax</h4>
<pre><code>
if condition:
    # execute code if condition is true
else:
    # execute code if condition is false</code></pre>
<h4>Example</h4>
<pre><code>x = 3
if x == 4:
    print("Yes")
else:
    print("No")</code></pre>
<h3>if-elif-else Ladder</h3>
<p>
    The elif statement is used to check for multiple conditions and execute the code block if any of the conditions are true.<br>
    Unlike else, multiple elif statements can follow an if statement.
</p>
<h3>Nested if Statements</h3>
<p>
    A nested if statement is an if statement inside another if statement.<br>
    These are generally used to check multiple conditions.
</p>
<h4>Example</h4>
<pre><code>height = int(input('Enter your height:'))
if height >= 15:
    print('You can ride')
    age = int(input('Please enter your age:'))
    if age <= 12:
        print('You can pay 100')
    elif age <= 10:
        print('You can pay 50')
else:
    print('You can’t ride')
    print('Thank you')</code></pre>
`,
codeExamples:`
<h1><b>Tasks</b></h1>
<ul>
    <li>Create a program that checks if you have more than 5 cookies. If you do, print "Cookie Party!" If not, print "Need more cookies!"</li>
    <li>Write a program that asks for the temperature outside. If it’s below 15°C, suggest wearing a jacket. If it’s above 25°C, suggest wearing shorts. For anything in between, suggest wearing something comfortable.</li>
    <li>Make a "Magic Gatekeeper" program where you can only pass if you have a key, or if you say the secret password. Otherwise, you’re not allowed in!</li>
    <li>Create a program that simulates a quiz with three possible answers (A, B, C). If the answer is correct, print "You win!" Otherwise, print "Try again!"</li>
    <li>Write a program that takes your age and checks if you're old enough to drive, vote, or retire. It should print a message based on your age!</li>
</ul>
`
},
"While Loops Part 1":{
    content:`
        <h1><b>Loops</b></h1>
    <p>Generally, a loop is something that coils around itself. 
        Loops in the programming context have a similar meaning. 
        In this, we will learn different types of loops in Python and discuss each of them in detail with examples. 
        So let us begin.</p>
    <h2>Introduction to loops:-</h2>
    <p>Loops are those constructs of a programming language that execute some piece of code a number of times under specified conditions.
         They are quite helpful in situations like going through every element of a list, performing an operation on a range of values, etc.
    </p>
    <p>There are two types of loops in Python and these are for and while loops.
        Both of them work by following the below steps:
    </p>
    <li>Firstly it's Checks the condition</li>
    <li>If it's true then it executes the body of block under it and update the iterator</li>
    <li>If False, come out of the loop</li>
    <img  src="images/loopsl.png" alt="loops explanation" height : 10px;>
    <h2><b>While loop:-</b></h2>
    <p>While loops execute a set of lines of code iteratively till a condition is satisfied. Once the condition results in False, it stops execution, and the part of the program after the loop starts executing.
The syntax of the while loop is :</p>
<pre><code><b>while condition:
    statement(s)</b></code></pre>
<h3>example :-</h3>
<p>An example of printing numbers from 1 to 4 is shown below.</p>
<pre><code>i=1              #intially the value of i is equal to 1      
while (i<=4):    #giving the condition to print only upto 4
    print(i)
    i=i+1<br>  
# the value of i will increased by 1 for every iteration and once again check the condition if it's true it execute else it's stops the execution.</code></pre>
<h3>Output: </h3>
<pre><code>1
2
3
4</code></pre>
<h3>explanation:-</h3>
<p>Here the condition checked is ‘i<=4’. For the first iteration, i=1 and is less than 4. So, the condition is True and 1 is printed. Then the ‘i’ value is incremented to print the next number and the condition is checked. When the value of ‘i’ becomes 5, the condition will be False and the execution of the loop stops.</p>
<h3>use of else in while loop</h3>
<p>Else is used for a similar purpose along with the while loop. The code in the else part is executed when the condition in the while gives False.</p>
<h3>Syntax:-</h3>
<pre><code>while condition:
    statement(s)
        else:
    statement(s)</code></pre>
<h3>Example on while loop with else:-</h3>
<pre><code>while(i<=4):
    print(i)
    i=i+1
else:
    print("End of the loop") #this else block will be executed when the                                 condition of while loop is false</code></pre>
<h3>Output:-</h3>
<pre><code>1
2
3
4</code></pre>`,
codeExamples:`
<h1>Tasks</h1>
<ul>
    <li>Create a program that prints the numbers from 1 to 10 using a while loop. After the loop, print "Done counting!"</li>

    <li>Write a program that loops through a list of your favorite foods and prints each one. After the loop, print "I'm hungry now!"</li>
    
    <li>Create a program that prints "Happy Birthday" ten times using a while loop.</li>
    
    <li>Write a while loop that prints all even numbers from 100 down to 1</li>
</ul>

`
},
"While Loops Part 2" :{
    content:`
    <h1>Do-While</h1>
    <p>Unlike the while loop, the do...while loop statement executes at least one iteration. </p>
    <p>It checks the condition at the end of each iteration and executes a code block until the condition is False.</p>
    <p>The following shows the pseudocode for the do...while loop in Python:</p>
    <h3>Syntax for do while loop:-</h3>
<pre><code>do
    # code block
    while condition</code></pre>
    <p>Unfortunately, Python doesn’t support the do...while loop. </p>
    <p> However, you can use the while loop and a break statement to emulate the do...while loop statement.</p>
    <p>First, specify the condition as True in the while loop like this:</p>
    <pre><code>while True:
    # code block</code></pre>
    <p>This allows the code block to execute for the first time. </p>
    <p>However, since the condition is always True, it creates an indefinite loop. This is not what we expected.</p>
    <p>Second, place a condition to break out of the while loop:</p>
    <pre><code>while True:
    # code block
    # break out of the loop
    if condition
        break</b></code></pre>
    <p>In this syntax, the code block always executes at least one for the first time and the condition is checked at the end of each iteration.</p>`,
    codeExamples:`
    `
},
"For Loops Part 1":{
    content:`
    <h2><b>For Loop</b></h2>
<p>For loop in Python works on a sequence of values. </p>
<p>For each value in the sequence, it executes the loop till it reaches the end of the sequence</p>
<img  src="images/cy7-forloop.png" alt="forloopsyntax" >
<h3>Initialization:</h3>
<p>i is initialized as the loop variable that will take values from the specified range.</p>
<p>in range(1,11) sets the range for i, where it starts from 1 and goes up to, but does not include, 11.</p>
<h3>Output for above code</h3>
<p>The output will print hello world 10 times because the loop runs 10 iterations (from 1 to 10).</p>
<p>The syntax for the for loop is:</p>
<pre><code>for iterator in sequence:
    statement(s)</b></code></pre>
<h3>Example to print numbers from 0 to 4 using for loop</h3>
<pre><code>for i in range(4):
    print(i)</code></pre>
<h3>Output:-</h3>
<pre><code>0
1
2
3
4</code></pre>
<h3>Example 2:-</h3>
<h3><b>Squaring of numbers using for loop</b></h3>
<pre><code><b>numbers = [1, 2, 3, 4, 5]
for number in numbers:
    print(number ** 2)
</b></code></pre>
<h3>output:-</h3>
<pre><code> 1
4
9
16
25</code></pre>
<h3><b>While loop vs for loop</b></h3>
    <img src="images/cy7-for-vs-while.png" alt="for vs while">
    <table border="1">
        <tr>
            <th>For Loop</th>
            <th>While Loop</th>
        </tr>
        <tr>
            <td>Used when the number of iterations is known.</td>
            <td>Used when the number of iterations is not known.</td>
        </tr>
        <tr>
            <td>If no condition is given, the loop can run infinitely.</td>
            <td>If no condition is given, an error is shown.</td>
        </tr>
        <tr>
            <td>Initialization is done once at the start.</td>
            <td>Initialization can be repeated if done inside the condition.</td>
        </tr>
        <tr>
            <td>Iteration (increment/decrement) happens after the loop body runs.</td>
            <td>Iteration can be written anywhere inside the loop.</td>
        </tr>
        <tr>
            <td>Initialization can occur inside or outside the loop.</td>
            <td>Initialization is usually outside the loop.</td>
        </tr>
        <tr>
            <td>Increment is usually simple and consistent.</td>
            <td>Increment can be more complex, varying by condition.</td>
        </tr>
        <tr>
            <td>Used when initialization and iteration are simple.</td>
            <td>Used when initialization and iteration are more complex.</td>
        </tr>
    </table>`,
    codeExamples:``
},
"For Loops Part 2":{
    content:`
        <h1><b>Nested for loop</b></h1>
    <p>A nested for loop allows you to execute one loop within another.</p>
    <p>The outer loop controls the number of iterations, </p><p>while the inner 
        loop runs completely for each iteration of the outer loop.</p>
    <p>This structure is useful for tasks that require multiple levels of iteration,</p> <p>such as working with lists of lists or generating combinations.</p>
    <p>Each iteration of the outer loop can trigger a full set of iterations in the inner loop,</p> <p>enabling complex data processing and organization.
    </p>
    <p>This will print pairs of numbers, like (1, 1), (1, 2), (1, 3), then (2, 1), and so on.</p>
    <p>It helps in working with multi-dimensional data, like grids or matrices.</p>
    <h3>syntax:</h3>
    <pre><code>for outer_variable in outer_iterable:
    for inner_variable in inner_iterable:
        # Execute some code</code></pre>
    <h3>Example 1:</h3>
        <pre><code>for i in range(1, 6):
        for j in range(1, 6 - i):
            print(i, j)</code></pre>
        <h3>Example 2:</h3>
        <pre><code>for i in range(1, 3):
        for j in range(1, 4):
            print('*', end='')
            print()</code></pre>
    <h3><b>While loop vs for loop</b></h3>
    <img src="images/cy7-for-vs-while.png" alt="for vs while">
    <table border="1">
        <tr>
            <th>For Loop</th>
            <th>While Loop</th>
        </tr>
        <tr>
            <td>Used when the number of iterations is known.</td>
            <td>Used when the number of iterations is not known.</td>
        </tr>
        <tr>
            <td>If no condition is given, the loop can run infinitely.</td>
            <td>If no condition is given, an error is shown.</td>
        </tr>
        <tr>
            <td>Initialization is done once at the start.</td>
            <td>Initialization can be repeated if done inside the condition.</td>
        </tr>
        <tr>
            <td>Iteration (increment/decrement) happens after the loop body runs.</td>
            <td>Iteration can be written anywhere inside the loop.</td>
        </tr>
        <tr>
            <td>Initialization can occur inside or outside the loop.</td>
            <td>Initialization is usually outside the loop.</td>
        </tr>
        <tr>
            <td>Increment is usually simple and consistent.</td>
            <td>Increment can be more complex, varying by condition.</td>
        </tr>
        <tr>
            <td>Used when initialization and iteration are simple.</td>
            <td>Used when initialization and iteration are more complex.</td>
        </tr>
    </table>`,
    codeExamples:`
        <h1>Tasks</h1>
<ul>
    <li>Create a program that prints the first 20 even numbers using for loop.</li>

    <li>Write a program that loops through a string and prints each character on a new line. After the loop, print "String traversal complete!"</li>

    <li>Create a program that prints the sum of all numbers from 1 to 100 using a for loop.</li>

    <li>Create a for loop that generates the first 10 numbers of the Fibonacci sequence.</li>

    <li>Write a for loop that prints a right-angle triangle pattern with asterisks (*)</li>
    <pre><code>*****
 ***
  *</code></pre>
</ul>
    `
},
"Functions Part 1":{
    content:`

    <h1>Functions in Python:-</h1>
    <p><b>A function is a block of code that performs a specific task.</b></p>
    <p>Suppose we need to crate a program to draw a square and color it. </p>
    <p>now we can create two functions to solve this problem.</p>
    <p>1.function to create a square</p>
    <p>2.function to color the shape</p>
    <p>By dividing a complex problem into smaller chunks makes our program easy to understand.</p>
    <h3><b>Create a Function</b></h3>
    <p>Let's create our first function.</p>
    <pre><code>def cybertron7():
    print('Hello World!')</code></pre>
    <p>Here are the different parts of the program:</p>
    <img  src="images/cy7 functions.jpg" alt="function " width="700px" height="auto">
    <p>Here, we have created a simple function named cybertron7() that prints <b>Hello World!</b></p>
    <h3><b>Calling a Function</b></h3>
    <p>In the above example, we have declared a function named cybertron7()</p>
    <p>If we run the above code, we won't get an output.</p>
    <p>It's because creating a function doesn't mean we are executing the code inside it.</p>
    <p>It means the code is there for us to use if we want to.</p>
    <p>To use this function, we need to call the function.</p>
    <h3><b>Function Call</b></h3>
    <pre><code>cybertron7()</code></pre>
    <h3>Example: Python Function Call</h3>
    <pre><code>def cybertron7():
    print('Hello World!')
    
# call the function
cybertron7()
    
print('Outside function')</code></pre>
<h3>Output:-</h3>
<pre><code>Hello World!
Outside function</code></pre>
<p>In the above example, we have created a function named cybertron7()</p>
<p>Here's how the control of the program flows:</p>
<img src="images/fun flow.jpg" alt="function flow">
<p>Here,</p>
<p>1.When the function cybertron7() is called,he program's control transfers to the function definition.</p>
<p>2.All the code inside the function is executed.</p>
<p>3.The control of the program jumps to the next statement after the function call.</p>


    `,
     codeExamples:`
     <p>The above are Basics tasks will be provided from Functions Part2</p>
     `
},
"Functions Part 2":{
    content:`
        <h2><b>Python Function Arguments:-</b></h2>
    <p>Arguments are inputs given to the function.</p>
    <pre><code>def cybertron7(name):
    print("Hello", name)
    
# pass argument
cybertron7("Ronaldo")</code></pre>
    <h3>Output:-</h3>
    <pre><code>Hello Ronaldo</code></pre>
    <p>Here, we passed 'ronaldo' as an argument to the cybertron7() function.</p>
    <p>We can pass different arguments in each call, making the function re-usable and dynamic.</p>
    <p>Let's call the function with a different argument.</p>
    <pre><code>cybertron7("Messi")</code></pre>
    <h3>output</h3>
    <pre><code>Hello Messi</code></pre>
    <h2><b>Example Problem for adding two nnumbers using functions</b></h2>
    <pre><code># function with two arguments
def add_numbers(num1, num2):
    sum = num1 + num2
    print("Sum: ", sum)
# function call with two values
add_numbers(5, 4)</code></pre>
    <h3>Output:-</h3>
    <pre><code>Sum: 9</code></pre>
    <h3>Explanation:-</h3>
    <p>In the above example, we have created a function named add_numbers() with arguments: num1 and num2.</p>
    <img src="images/function ex.png" alt="function example">

    <h1><b>The return statement</b></h1>
    <p>We return a value from the function using the return statement.</p>
    <h3>Example :-</h3>
    <pre><code># function definition
def find_square(num):
    result = num * num
    return result
# function call
square = find_square(3)
print('Square:', square)</code></pre>
    <h3>Output:-</h3>
    <pre><code>Square: 9</code></pre>
    <p>In the above example, we have created a function named find_square().</p>
    <p>The function accepts a number and returns the square of the number.</p>
    <img src="images/function ex1.png" alt="function ex1">
    <p><b>Note:</b> The return statement also denotes that the function has ended</Note:>
    </p>
    <p> Any code after return is not executed.</p>
    `,
    codeExamples:`
    <h1>Tasks</h1>
<ul>
    <li>Write a function to check if a given number is prime or not</li>
    <li>A prime number is only divisible by 1 and itself. For example, <b>13.</b></li>
    <li>Return True if the number is prime, otherwise return False.</li>
</ul>
    `
}


    


    

};
const fuse = new Fuse(cleanTopics, {
    includeScore: true,
    threshold: 0.3, 
});
const startDate = new Date('2024-09-16'); // Fixed start date

function updateLearningPath() {
    const now = new Date();
    const daysPassed = Math.floor((now - startDate) / (1000 * 60 * 60 * 24));

    console.log(`Days Passed: ${daysPassed}`);
    console.log(`Today's Date: ${now.toDateString()}`);
    console.log(`Start Date: ${startDate.toDateString()}`);

    const learningPath = document.getElementById('learningPath');
    learningPath.innerHTML = '';

    rawTopics.forEach((topic, index) => {
        const moduleDiv = document.createElement('div');

        // Unlock the module if the daysPassed is greater than or equal to the module's index
        const isUnlocked = daysPassed >= index;

        moduleDiv.className = 'module ' + (isUnlocked ? 'unlocked' : 'locked');
        moduleDiv.id = 'module-' + index;
        moduleDiv.innerHTML = `
            <div class="icon">${isUnlocked ? '🔓' : '🔒'}</div>
            ${topic}
        `;

        if (isUnlocked) {
            moduleDiv.addEventListener('click', () => {
                const cleanTopic = cleanTopics[index];
                const contentAndCodeForTopic = contentAndCode[cleanTopic] || { content: 'No content available', codeExamples: '' };
                document.getElementById('topicTitle').style.display = "none";
                document.getElementById('topicContent').innerHTML = `${contentAndCodeForTopic.content}<br>${contentAndCodeForTopic.codeExamples}`;
            });
        } else {
            const unlockDate = new Date(startDate);
            unlockDate.setDate(unlockDate.getDate() + index);
            moduleDiv.innerHTML += `<br><small>Unlocks on ${unlockDate.toDateString()}</small>`;
        }

        learningPath.appendChild(moduleDiv);
    });
}

// Call the function to update the learning path on page load


document.getElementById('toggleLearningPathButton').addEventListener('click', () => {
    const learningPath = document.getElementById('learningPath');
    const button = document.getElementById('toggleLearningPathButton');

    if (learningPath.classList.contains('hidden')) {
        learningPath.classList.remove('hidden');
        button.textContent = 'Close task bar';
    } else {
        learningPath.classList.add('hidden');
        button.textContent = 'Show task bar';
    }
});


function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const suggestions = document.getElementById('suggestions');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value;
        const results = fuse.search(query);
        suggestions.innerHTML = '';
        
        if (query.length > 0) {
            results.forEach(result => {
                const div = document.createElement('div');
                const cleanResultText = cleanTopics[result.refIndex];
                div.textContent = cleanResultText;
                div.addEventListener('click', () => {
                    searchInput.value = cleanResultText;
                    suggestions.style.display = 'none';
                    const index = result.refIndex;
                    const contentAndCodeForTopic = contentAndCode[cleanResultText] || { content: 'No content available', codeExamples: '' };
                    document.getElementById('topicTitle').innerHTML = cleanResultText;
                    document.getElementById('topicContent').innerHTML = `${contentAndCodeForTopic.content}<br>${contentAndCodeForTopic.codeExamples}`;
                });
                suggestions.appendChild(div);
            });
            suggestions.style.display = 'block';
        } else {
            suggestions.style.display = 'none';
        }
    });

    document.addEventListener('click', (event) => {
        if (!searchInput.contains(event.target) && !suggestions.contains(event.target)) {
            suggestions.style.display = 'none';
        }
    });
}

// Back button functionality
function backbutton() {
    window.location.href = "https://www.cybertron7.in/Login/main-interface.php";
}



// Text-to-speech functionality
function initTextToSpeech() {
    const speakButton = document.getElementById('speakButton');
    const stopButton = document.getElementById('stopButton');
    const contentDiv = document.getElementById('topicContent');
    let utterance;

    speakButton.addEventListener('click', () => {
        if (contentDiv.textContent.trim()) {
            utterance = new SpeechSynthesisUtterance(contentDiv.textContent);
            window.speechSynthesis.speak(utterance);
            speakButton.style.display = 'none';
            stopButton.style.display = 'inline';
        }
    });

    stopButton.addEventListener('click', () => {
        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.cancel();
            speakButton.style.display = 'inline';
            stopButton.style.display = 'none';
        }
    });
}

// Hide loading screen after page load
window.addEventListener('load', function() {
    var loadingScreen = document.getElementById('loading-screen');
    loadingScreen.style.display = 'none';
});

let darkTheme = true;

// Load Pyodide and required packages
async function loadPyodideAndPackages() {
    const pyodide = await loadPyodide();
    return pyodide;
}

let pyodideReadyPromise = loadPyodideAndPackages();
async function runCode() {
    const code = editor.getValue(); // Get the code from CodeMirror
    const userInputElement = document.getElementById('user-input'); // Get the user input element

    const userInput = userInputElement ? userInputElement.value : ''; // Get the value of the input

    let pyodide = await pyodideReadyPromise; // Ensure Pyodide is ready

    try {
        // Setup stdin to handle user input in the Python code
        await pyodide.runPython(`
import sys
from io import StringIO

output = StringIO()  # To capture print outputs
sys.stdout = output
sys.stderr = output

# Simulating stdin for input() calls
input_values = ${JSON.stringify(userInput.split('\\n'))}  # Split user input by new lines

class CustomInputStream:
    def __init__(self, inputs):
        self.inputs = inputs
        self.index = 0
    
    def readline(self):
        if self.index >= len(self.inputs):
            raise EOFError("No more input")
        line = self.inputs[self.index]
        self.index += 1
        return line

sys.stdin = CustomInputStream(input_values)  # Simulate stdin using the custom class

        `);

        // Run the user's Python code asynchronously
        let result = await pyodide.runPythonAsync(code);

        // Get the output from stdout
        let output = pyodide.runPython('output.getvalue()');

        // Display the output in the output div
        document.getElementById('output').textContent = output;

    } catch (err) {
        // Handle any errors by displaying them
        document.getElementById('output').textContent = err;
    }
}


// Save code to a file
function saveCode() {
    const code = editor.getValue();
    const blob = new Blob([code], { type: "text/plain;charset=utf-8" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "code.py";
    link.click();
}

// Toggle between dark and light themes
function toggleTheme() {
    darkTheme = !darkTheme;
    if (darkTheme) {
        document.body.classList.remove("light-theme");
        editor.setOption("theme", "material-darker");
        document.querySelector('.theme-switch span').textContent = "light_mode";
    } else {
        document.body.classList.add("light-theme");
        editor.setOption("theme", "default");
        document.querySelector('.theme-switch span').textContent = "dark_mode";
    }
}

// Initialize the CodeMirror editor
let editor = CodeMirror(document.getElementById('editor'), {
    mode: "python",
    theme: "material-darker",
    lineNumbers: true,
    extraKeys: { "Ctrl-Space": "autocomplete" },
});

// Next theory content functionality
function nextTheory() {
    let currentTheory = document.getElementById('theory-content').textContent.trim();
    let theories = [
        "This section contains the theory related to the Python concepts you'll practice in the compiler. You can write explanations, code examples, and other relevant information here.",
        "Variables in Python: Variables are containers for storing data values. In Python, you don't need to declare the type of a variable.",
        "Next theory content here."
    ];
    let index = theories.indexOf(currentTheory);
    index = (index + 1) % theories.length;
    document.getElementById('theory-content').innerHTML = theories[index];
}

// Back button functionality
document.getElementById('backButton').addEventListener('click', function() {
    window.history.back();
});


// Initialize the page
updateLearningPath();
initSearch();
initTextToSpeech();
