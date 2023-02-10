<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Invoice Task</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('invoice_tasks.index') }}" enctype="multipart/form-data">
                    Back</a>
            </div>
        </div>
    </div>
    @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('invoice_tasks.update',$invoice_task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Invoice:</strong>
                    <select name="invoice_id" class="form-control">
                        @foreach($invoices as $invoice)
                            @if($invoice->id == $invoice_task->invoice->id)
                                <option selected value="{{$invoice->id}}">{{$invoice->date}}</option>
                            @else
                                <option value="{{$invoice->id}}">{{$invoice->date}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tag:</strong>
                    <input type="string" name="tag" value="{{$invoice_task->tag}}" class="form-control">
                    @error('tag')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <input type="string" name="desc" value="{{$invoice_task->desc}}" class="form-control">
                    @error('desc')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Fix price:</strong>
                    <input type="number" name="fix_price" value="{{$invoice_task->fix_price}}" class="form-control">
                    @error('fix_price')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-3">Submit</button>
        </div>
    </form>
</div>
</body>

</html>
