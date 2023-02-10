<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Tasks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Invoice Tasks</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('invoice_tasks.create') }}"> Create Invoice Task</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('danger'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Invoice</th>
            <th>Tag</th>
            <th>Description</th>
            <th>Fix price</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoiceTasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->invoice->date }}</td>
                <td>{{ $task->tag }}</td>
                <td>{{ $task->desc }}</td>
                <td>{{ $task->fix_price }}</td>
                <td>
                    <form action="{{ route('invoice_tasks.destroy',$task->id) }}" method="Post">
                        <a class="btn btn-primary" href="{{ route('invoice_tasks.edit',$task->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
