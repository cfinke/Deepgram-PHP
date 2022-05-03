An unofficial PHP SDK for Deepgram's API.

Getting Started
---------------
Grab `src/deepgram.php` and include it in your project.

Then:

```
$deepgram = new Deepgram( [your API key here] );
```

Now, you have access to the Deepgram API endpoints. For example,

```
$projects = $deepgram->projects();

var_dump( $projects );
```

displays

```
array(2) {
	[0]=>
	object(Deepgram_Project)#2 (3) {
		[...]
	}
	[1]=>
	object(Deepgram_Project)#3 (3) {
		[...]
	}
}
```

(if your API key has two projects).
