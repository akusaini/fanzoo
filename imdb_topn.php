<?php

//Script is made for both command line and web browser.
//For command line "php imdb_topn.php 3 "Morgan Freeman"".
//For web browser url is http://localhost/imdb_topn.php?arg1=3&arg2=Morgan Freeman
//Taking the argument after checking from where the script is called.
if (PHP_SAPI === 'cli') {
    if (sizeof($argv) == 2) {
        $numberOfMovies = $argv[1];
    } elseif (sizeof($argv) > 2) {
        $numberOfMovies = $argv[1];
        $actorName = $argv[2];
        $actorMovie = array();
    } elseif (sizeof($argv) == 1) {
        $numberOfMovies = 250;
    }
} else {
    $numberOfMovies = $_GET['arg1'];
    if (isset($_GET['arg2'])) {
        $actorName = $_GET['arg2'];
        $actorMovie = array();
    }
}

//Loading the data from the url.
$html = file_get_contents('http://www.imdb.com/chart/top?ref_=nv_mv_250_6');
libxml_use_internal_errors(true);
//Dom object.
$dom = new DOMDocument();
$dom->loadHTML($html);
$finder = new DomXPath($dom);
$className = "titleColumn";
$spaner = $finder->query("//*[contains(@class, '$className')]");

$count = 0;
//iterating through the number of movies user demand for.
while ($count < $numberOfMovies) {
    $movie = $spaner->item($count);
    $movie = $movie->getElementsByTagName('a');
    $data = $movie->item(0);

    if (isset($actorName)) {
        $actors = $data->getAttribute('title');
        $actors = explode(',', $actors);
        foreach ($actors as $actor) {
            if ($actor == ' ' . $actorName) {
                $actorMovie[$actorName] = "";
                $actorMovie[$actorName] = $actorMovie[$actorName] . ',' . $data->textContent;
            }
        }
    }
    echo ($count + 1) . ") " . $data->textContent . "\n";
    $count++;
}

//Displaying the name of movies based on actor.
if (isset($actorName)) {
    if (isset($actorMovie[$actorName])) {
        echo "\n\nMovie " . $actorName . " played in :\n";
        $movies = explode(",", $actorMovie[$actorName]);
        $count = 1;
        foreach ($movies as $singleMovie) {
            if ($count != 1)
                echo ($count - 1) . ") " . $singleMovie . "\n";
            $count++;
        }
    }else {
        echo "\nThe Actor with name " . $actorName . " dosen't played role in any movies.";
    }
}
?>


