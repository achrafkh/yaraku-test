<?php

namespace App\Utils;

class CsvExporter
{
    protected $delimiter;
    protected $filename = 'books.csv';

    protected $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; ",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0",
    ];

    public function __construct($delimiter = ',')
    {
        $this->delimiter = $delimiter;
    }

    public function setFilename($filename = 'books.csv')
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
        $fh = fopen('php://temp', 'rw');

        // get keys
        fputcsv($fh, array_keys(current($data)));

        //fill values
        foreach ($data as $row) {
            fputcsv($fh, $row);
        }

        //set cursor bac kat top
        rewind($fh);

        // get content & close the file
        $csv = stream_get_contents($fh);
        fclose($fh);

        // return content
        return $csv;
    }
}
