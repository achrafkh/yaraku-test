<?php

namespace App\Utils;

use DOMDocument;

class XmlExporter
{
    protected $delimiter;
    protected $filename = 'books.xml';

    protected $headers = [
        "Content-type" => "text/plain",
        "Content-Disposition" => "attachment; ",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0",
    ];

    public function __construct($delimiter = ',')
    {
        $this->delimiter = $delimiter;
    }

    public function setFilename($filename = 'books.xml')
    {
        $this->headers['Content-Disposition'] .= 'filename=' . $filename;
        $this->filename = $filename;

        return $this;
    }

    public function getFileName()
    {
        return $this->filename;
    }

    public function getHeaders()
    {

        return $this->headers;
    }

    public function parse($data)
    {
        $count = count($data);

        //create the xml document
        $xmlDoc = new DOMDocument();

        $root = $xmlDoc->appendChild($xmlDoc->createElement("data"));
        $root->appendChild($xmlDoc->createElement("count", $count));

        $tabBooks = $root->appendChild($xmlDoc->createElement('values'));

        foreach ($data as $book) {
            if (!empty($book)) {
                $tabBook = $tabBooks->appendChild($xmlDoc->createElement('book'));
                foreach ($book as $key => $val) {
                    $tabBook->appendChild($xmlDoc->createElement($key, $val));
                }
            }
        }

        return $xmlDoc->saveXML();
    }
}
