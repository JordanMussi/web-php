<?php
require_once 'prepend.inc';

$lang = default_language();
if (!@is_dir("$DOCUMENT_ROOT/manual/$lang")) {
    $lang = "en"; // fall back to English
}

$SIDEBAR_DATA='
<h3>More tutorials</h3>
<p>
There are other excellent PHP tutorials available:<br><br>
&nbsp; <a href="http://conf.php.net/">PHP presentations</a><br>
&nbsp; <a href="http://www.zend.com/zend/art/intro.php">Zend Intro to PHP</a><br>
&nbsp; <a href="http://www.hotwired.com/webmonkey/99/21/index2a.html">WebMonkey</a><br>
&nbsp; <a href="http://www.devshed.com/Server_Side/PHP/Introduction/">DevShed</a><br>
&nbsp; <a href="http://www.phpbuilder.com/getit/">PHP Builder</a><br>
&nbsp; <a href="http://www.melonfire.com/community/columns/trog/archives.php?category=PHP">Melonfire</a><br>

<h3>Books</h3>
<p>
<a href="/books.php">Books</a> are convenient resources to begin exploring 
PHP. <a href="/books.php">The titles listed here</a> will help you to start 
learning PHP, as well as extending your existing knowledge.
</p>
';

commonHeader('PHP Tutorial');

	function example($text) {
		echo "<blockquote><table border=\"0\" cellpadding=\"3\" cellspacing=\"3\"><tr bgcolor=\"#d0d0d0\"><td>";
		highlight_string($text);
		echo "</td></tr></table></blockquote>";
	}
?>

<h1>Introductory Tutorial</h1>

<p>
PHP is a tool that lets you create dynamic web pages. PHP-enabled
web pages are treated just like regular HTML pages and you can create
and edit them the same way you normally create regular HTML pages.
</p>

<h2>What do I need?</h2>

<p>In this tutorial we assume that your server has support for PHP
activated and that all files ending in <i>.php</i> are handled by PHP.
On most servers this is the default extension for PHP files, but
ask your server administrator to be sure. If your server supports
PHP then you don't need to do anything. Just create your <i>.php</i>
files and put them in your web directory and the server will
magically parse them for you. There is no need to compile anything
nor do you need to install any extra tools. Think of these
PHP-enabled files as simple HTML files with a whole new family
of magical tags that let you do all sorts of things.
</p>

<h2>Your first PHP-enabled page</h2>

<p>
Create a file named <i>hello.php</i> and in it put the following lines:
</p>

<?php example('<html><head><title>PHP Test</title></head>
<body>
<?php echo "Hello World<p>"; ?>
</body></html>
')?>

<p>
The colours you see are just a visual aid to make it easier to see
the PHP tags and the different parts of a PHP expression. Note also
that this is not like a CGI script. The file does not need to be
executable or special in any way. Think of it as a normal HTML
file which happens to have a set of special tags available to you
that do a lot of interesting things.
</p>

<p>
This program is extremely simple and you really didn't need to use
PHP to create a page like this.  All it does is display:
<b>Hello World</b>
</p>

<p>
If you tried this example and it didn't output anything, chances
are that the server you are on does not have PHP enabled. Ask your
administrator to enable it for you.
</p>

<p>
The point of the example is to show the special PHP tag format.
In this example we used <b>&lt;?php</b> to indicate the start of
a PHP tag. Then we put the PHP statement and left PHP mode by
adding the closing tag, <b>?&gt;</b>.  You may jump in and out
of PHP mode in an HTML file like this all you want.
</p>

<h2>Something Useful</h2>

<p>
Let's do something a bit more useful now. We are going to check
what sort of browser the person viewing the page is using.
In order to do that we check the user agent string that the browser
sends as part of its request. This information is stored in a variable.
Variables always start with a dollar-sign in PHP. The variable we
are interested in is <b>$_SERVER["HTTP_USER_AGENT"]</b>.  To display this
variable we can simply do:
</p>

<?php example('<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>')?>

<p>
For the browser that you are using right now to view this page,
this displays:
<blockquote><?php echo $_SERVER["HTTP_USER_AGENT"]; ?></blockquote>
There are many other variables that are automatically set by
your web server. You can get a complete list of them by creating
a file that looks like this:
</p>

<?php example('<?php phpinfo(); ?>');?>

<p>
Then load up this file in your browser and you will see a page
full of information about PHP along with a list of all the
variables available to you.
</p>

<p>
You can put multiple PHP statements inside a PHP tag and create
little blocks of code that do more than just a single echo.
For example, if we wanted to check for Internet Explorer we
could do something like this:
</p>

<?php example('<?php
if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
	echo "You are using Internet Explorer<br />";
}
?>');?>

<p>
Here we introduce a couple of new concepts. We have an
&quot;<?php print_link ('/manual/' . $lang . '/control-structures.php#control-structures.if', 'if'); ?>&quot;
statement. If you are familiar with the basic syntax used by the C
language this should look logical to you. If you don't know enough
C or some other language where the syntax used above is used, you
should probably pick up any introductory C book and read the first
couple of chapters. All the tricky string and memory manipulation
issues you have to deal with in C have been eliminated in PHP, but
the basic syntax remains.
</p>

<p>
The second concept we introduced was the <?php print_link ('/manual/' . $lang . '/function.strstr.php', 'strstr()'); ?> function call.
strstr() is a function built into PHP which searches a string for
another string. In this case we are looking for &quot;MSIE&quot; inside
$_SERVER["HTTP_USER_AGENT"]. If the string is found the function returns true
and if it isn't, it returns false. If it returns true the following 
statement is executed.
</p>

<p>
We can take this a step further and show how you can jump in and out
of PHP mode even in the middle of a PHP block:
</p>

<?php example('<?php
if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
?>
<center><b>You are using Internet Explorer</b></center>
<?php
} else {
?>
<center><b>You are not using Internet Explorer</b></center>
<?php
}
?>');?>

<p>
Instead of using a PHP echo statement to output something, we jumped
out of PHP mode and just sent straight HTML. The important and powerful
point to note here is that the logical flow of the script remain intact.
Only one of the HTML blocks will end up getting sent to the viewer.
Running this script right now results in:
</p>

<?php
if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
?>
<center><b>You are using Internet Explorer</b></center>
<?php
} else {
?>
<center><b>You are not using Internet Explorer</b></center>
<?php
}
?>

<h2>Dealing with Forms</h2>

<p>
One of the most powerful features of PHP is the way it handles HTML
forms. The basic concept that is important to understand is that any
form element in a form will automatically result in a variable
with the same name as the element being created on the target page.
This probably sounds confusing, so here is a simple example.
Assume you have a page with a form like this on it:
</p>

<?php example('<form action="action.php" method="post">
Your name: <input type="text" name="name">
Your age: <input type="text" name="age">
<input type="submit">
</form>');?>

<p>
There is nothing special about this form. It is a straight HTML form
with no special tags of any kind. When the user fills in this form
and hits the submit button, the <i>action.php</i> page is called.
In this file you would have something like this:
</p>

<?php example('Hi <?php echo $HTTP_POST_VARS["name"]; ?>.
You are <?php echo $HTTP_POST_VARS["age"]; ?> years old.')?>

<p>
It should be obvious what this does. There is nothing more to it.
The $_POST["name"] and $_POST["age"] variables
are automatically set for you by PHP. (<b>Note:</b> On versions 
previous to PHP 4.1.0, one needed to use the $HTTP_POST_VARS array
instead of the $_POST superglobal array. See the section on 
<?php print_link('/manual/'.$lang.'/language.variables.predefined.php',
'"Predefined variables"'); ?> in the manual for more information).
</p>

<h2>Using old code with new versions of PHP</h2>

<p>
Now that PHP has grown to be a popular scripting language, there are
more resources out there that have listings of code you can reuse
in your own scripts. For the most part the developers of the PHP
language have tried to be backwards compatible, so a script written
for an older version should run (ideally) without changes in a newer
version of PHP, in practice some changes will usually be needed.
</p>
<p>
Two of the most important recent changes that affect old code are:
<ol>
<li>The deprecation of the old $HTTP_*_VARS arrays (which need to be
indicated as global when used inside a function or method), for the
superglobal arrays $_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_REQUEST,
and $_SESSION, which are always accessible even from inside a function
scope. (PHP &gt;= 4.1.0)</li>
<li>External variables are no longer registered in the global scope by
default (in other words, "register_globals=off" by defaults in php.ini),
which means that the preferred method of accessing those values is via
the superglobal arrays mentioned above. (PHP &gt;= 4.2.0)
</ol>
For more details on these changes see the manual section on 
<?php print_link('/manual/'.$lang.'/language.variables.predefined.php',
'predefined variables'); ?> and links therein.
</p>

<h2>What's next?</h2>

<p>
With what you know now you should be able to understand the online
manual and also the various example scripts available
in the example archives. Look at the <a href="/docs.php">Manual</a>
and our <a href="/links.php">Links</a> section.
</p>

<?php commonfooter(); ?>
