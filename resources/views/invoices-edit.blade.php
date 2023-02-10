<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoices</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Invoice</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('invoices.index') }}" enctype="multipart/form-data">
                    Back</a>
            </div>
        </div>
    </div>
    @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('invoices.update',$invoice->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Date:</strong>
                    <input type="date" name="date" value="{{ now()}}" class="form-control">
                    @error('date')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Project:</strong>
                    <select name="project_id" class="form-control">
                        @foreach($projects as $project)
                            @if($project->id == $invoice->project_id)
                                <option selected value="{{$project->id}}">{{$project->name}}</option>
                            @else
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Board:</strong>
                    <select name="idBoard" class="form-control">
                        @foreach($boards as $board)
                            @if($board->idBoard == $invoice->idBoard)
                                <option selected value="{{$board->idBoard}}">{{$board->name}}</option>
                            @else
                                <option value="{{$board->idBoard}}">{{$board->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-3">Submit</button>
        </div>
    </form>
</div>
</body>

</html>
