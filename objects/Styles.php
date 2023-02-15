<?php

class Styles
{
    protected $gogglesStyle = "<style type=\"text/css\" style=\"display: none\">" .
        ".riadok{" .
        "display: table;" .
        "width: 100%;" .
        "}" .
        ".polovica{" .
        "margin: 3vh 0;" .
        "text-align: justify;" .
        "text-align-last: center;" .
        "}" .
        ".obrazok{" .
        "text-align: center;" .
        "font-family: FFMeta;" .
        "font-style: italic;" .
        "font-size: 300%;" .
        "}" .
        ".sosovkainfo{" .
        "display: flex;" .
        "flex-wrap: wrap;" .
        "}" .
        ".sosovka{" .
        "text-align: center;" .
        "width: 100%;" .
        "}" .
        ".infocast{" .
        "width: 100%;" .
        "}" .
        ".inforiadok{" .
        "display: table;" .
        "width: 100%;" .
        "}" .
        ".stvrtina{" .
        "width: 25%;" .
        "margin: auto;" .
        "display: table-cell;" .
        "text-align: center;" .
        "}" .
        "@media only screen and (min-width: 768px) {" .
        "/* For desktop: */" .
        ".polovica {" .
        "width: 48%;" .
        "margin: auto 0;" .
        "}" .
        ".riadok{" .
        "margin: 5vh 0;" .
        "display: flex;" .
        "flex-flow: row;" .
        "justify-content: center;" .
        "}" .
        ".stred{width: 4%;order: 2;}" .
        ".pravo{order:3;}" .
        ".lavo{order:1;}" .
        ".sosovkainfo{" .
        "flex-wrap: nowrap;" .
        "align-items: center;" .
        "}" .
        ".sosovka{" .
        "width: 33.33%;" .
        "}" .
        ".infocast{" .
        "width: 66.66%;" .
        "}" .
        ".obrazok{" .
        "font-size: 450%;" .
        "}" .
        "}" .
        "</style>";

    protected $glassesStyle = "<style type=\"text/css\" style=\"display: none\">" .
        ".riadok{" .
        "display: table;" .
        "width: 100%;" .
        "}" .
        ".polovica{" .
        "margin: 3vh 0;" .
        "text-align: justify;" .
        "}" .
        ".blok_nadpis{" .
        "font-size: 150%;" .
        "font-weight: 600;" .
        "text-align: left;" .
        "}" .
        ".obrazok{" .
        "text-align: center;" .
        "}" .
        "@media only screen and (min-width: 768px) {" .
        "/* For desktop: */" .
        ".polovica {" .
        "width: 49%;" .
        "margin: auto 0;" .
        "}" .
        ".riadok{" .
        "margin: 3vh 0;" .
        "display: flex;" .
        "flex-flow: row;" .
        "justify-content: center;" .
        "}" .
        ".stred{width: 2%;order: 2;}" .
        ".pravo{order:3;}" .
        ".lavo{order:1;}" .
        ".blok_nadpis{" .
        "font-size: 150%;" .
        "font-weight: 600;" .
        "text-align: left;" .
        "text-align-last: left;" .
        "}}</style>";

    public function getGogglesStyle()
    {
        return $this->gogglesStyle;
    }

    public function getGlassesStyle()
    {
        return $this->glassesStyle;
    }
}