<?php

function technologiesHeader($title)
{
    return "<div style = \"font-weight: 600; text-align: center; margin-top: 3em; margin-bottom: 2em;\">" .
        "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\"><span style=\"background-color: #fff; " .
        "padding: 0 5px; position: relative; top: -10px; letter-spacing: 2px; font-size: 12.65px;\">"
        . $title . "</span></div></div>";
}

function gogglesTechnologies($title, $description, $url = null, $i)
{
    $text = "<div class=\"riadok\">" .
        (isset($url) ? "<div class=\"polovica " . ($i % 2 != 0 ? 'pravo' : 'lavo') . " obrazok\"><img src=\"" . $url . "\" alt=\"" . $title . "\" style=\"max-width: 80%;\">" : "<div class=\"polovica " . ($i % 2 != 0 ? 'pravo' : 'lavo') . " obrazok\" style=\"font-size:300%\">" . $title) .
        "</div>" .
        "<div class=\"stred\"></div>" .
        "<div class=\"polovica " . ($i % 2 != 0 ? 'lavo' : 'pravo') . "\">" . $description .
        "</div>" .
        "</div>";

    return $text;
}

function riadok($title, $description, $url = null)
{
    $text =
        "<div style=\"margin:3em;\"></div>" .
        "<div class=\"riadok\">" .
        "<div class=\"polovica lavo obrazok\">" .
        (isset($url) ? "<img src=\"" . $url . "\" alt=\"" . $title . "\" style=\"height: 10vh;max-width: 80%;vertical-align: middle;\">" : "<div class=\"polovica lavo obrazok\" style=\"font-size:300%\">" . $title) .
        "</div>" .
        "<div class=\"stred\"></div>" .
        "<div class=\"polovica pravo\">" .
        "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $title . "</p>" .
        "<p>" . $description . "</p>" .
        "</div>" .
        "</div>";

    return $text;
}

function divider()
{
    return "<div style=\"font-weight: 600; text-align: center; margin-top: 1em; margin-bottom: 1em;\">" .
        "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
        "</div>" .
        "</div>";
}