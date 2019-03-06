@extends('layouts.master')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap.min.css">

@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="cardParent" class="card dimmer active" style="height:100%;position:relative;flex:1 1 auto;">
                    <div class="loader"></div>
                    <div class="card-header">Books</div>
                    <div class="card-body dimmer-content " >
                    <div class="pull-right"  style="margin-bottom: 5px;">
                        <button type="button" id="addBook" class="btn btn-info">Add</button>
                        <div class="btn-group ">
                            <button data-toggle="modal" data-target="#exportModal" type="button" class="btn btn-info export" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Export
                            </button>

                        </div>
                    </div>
                        <div class="table-responsive ">
                            <table class="table" class="dt-table" id="booksTable">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th width="5%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="exportForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Options</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                          <label class="form-label">Filename</label>
                          <input type="text" class="form-control" name="filename" placeholder="Filename" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Select Columns</label>
                        <div class="selectgroup selectgroup-pills">
                            @foreach(config('datasets.columns.books') as $cols)
                            <label class="selectgroup-item">
                                <input type="checkbox" name="selected_columns[]" value="{{ $cols }}" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">{{ ucfirst($cols) }}</span>
                            </label>
                            @endforeach
                        </div>
                        <div class="form-group">
                        <div class="form-label">Inline Radios</div>
                        <div class="custom-controls-stacked">
                          @foreach(config('datasets.export.books') as $option)
                          <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="type" value="{{$option}}" @if($loop->first) checked="" @endif>
                            <span class="custom-control-label">{{ ucFirst($option) }}</span>
                          </label>
                          @endforeach
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary dismiss-export" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="FormModal" tabindex="-1" role="dialog" aria-labelledby="FormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="FormModalLabel"></h5>
            </div>
            <form id="form">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="title" class="control-label">{{ 'Title' }}</label>
                        <input class="form-control" name="title" type="text" id="title" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="author" class="control-label">{{ 'Author' }}</label>
                        <input class="form-control" name="author" type="text" id="author" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary dismiss" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('js')

<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    var endpoint = {!! json_encode(url('/books')) !!};
    var columns = {!! json_encode(config('datasets.columns.books')) !!};
</script>

<script type="text/javascript" src="/js/books/index.js"></script>

@endsection
