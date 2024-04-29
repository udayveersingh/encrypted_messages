@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('You are logged in!') }} --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/messages')  }}" method="post">
                        @csrf
                       <div class="my-4">
                        <textarea  id="" cols="30" rows="10" class="form-control" name="text">{{ old('text') }}</textarea>
                       </div>
                       
                       <div class="my-4">
                            <select name="recipient_id" id="" class="form-control">
                            <option value="">Choose User</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>

                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
