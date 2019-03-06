<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BooksRepositoryInterface;
use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;
use Storage;
use Validator;

class ExportController extends Controller
{

    // there are two methods for exporting
    // One uses custom classes
    // the second uses a package "soapbox/laravel-formatter" to handle the parsing

    protected $books;

    protected $tempFolder = 'temp';

    // Maybe its better if we put this in a Config file
    // this is needed for custom parsers
    protected $exporters = [
        'csv' => \App\Utils\CsvExporter::class,
        'xml' => \App\Utils\XmlExporter::class,
    ];

    public function __construct(BooksRepositoryInterface $books)
    {
        $this->books = $books;
    }

    // custom Parsers
    public function exports($type, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'selected_columns' => 'present|array|required',
            'filename' => 'required',
        ], ['present' => 'At least one Option has to be selected in :attribute']);

        if ($validator->fails() && $request->ajax()) {
            return response()->json($validator->errors(), 200);
        } elseif ($request->ajax()) {
            return response()->json([], 200);
        }

        // check if export option is available
        if (!isset($this->exporters[$type])) {
            abort(404);
        }

        $order = head($request->order);
        $keyword = $request->search['value'];

        $cols = $request->get('selected_columns');

        $filename = (trim($request->get('filename') != '')) ? $request->get('filename') : 'export';
        $filename .= '.' . $type;

        $data = $this->books->exportData($order, $keyword, $cols)->toArray();

        // instantiate the class based on selected type
        $instance = (new $this->exporters[$type]);

        $instance->setFilename($filename);

        $fileContents = $instance->parse($data);

        $path = $this->tempFolder . '/' . str_random(10);

        Storage::put($path, $fileContents);

        return response()->download(storage_path('app/' . $path), $instance->getFileName(), $instance->getHeaders())->deleteFileAfterSend();
    }

    // Used a packaged for Parsing in this method
    public function export($type, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'selected_columns' => 'present|array|required',
            'filename' => 'required',
        ], ['present' => 'At least one Option has to be selected in :attribute']);

        if ($validator->fails() && $request->ajax()) {
            return response()->json($validator->errors(), 200);
        } elseif ($request->ajax()) {
            return response()->json([], 200);
        }

        $order = head($request->order);
        $keyword = $request->search['value'];

        $filename = (trim($request->get('filename') != '')) ? $request->get('filename') : 'export';
        $filename .= '.' . $type;

        $cols = $request->get('selected_columns');

        $data = $this->books->exportData($order, $keyword, $cols)->toArray();

        $method = 'to' . ucfirst($type);

        $formatter = Formatter::make($data, Formatter::ARR);

        if (!method_exists($formatter, $method)) {
            abort(404);
        }

        $fileContents = $formatter->{$method}();

        $path = $this->tempFolder . '/' . str_random(10);

        Storage::put($path, $fileContents);

        // get data from storage , send it for download and then delete it
        return response()->download(storage_path('app/' . $path), $filename, [
            "Content-type" => "text/csv",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ])->deleteFileAfterSend();
    }
}
