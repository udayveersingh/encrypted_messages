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

                    @foreach ($messages as $key=> $item)
                        <div class="card p-3" >
                            <a href="#" class="get-message" data-text="{{ $item->text }}"  data-id="{{ $item->id }}">View Message {{ $key+1 }}</a>
                        </div>
                    @endforeach
                 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('.get-message').click(function(e) {
            e.preventDefault();
            let text = $(this).data('text');
            let id = $(this).data('id');
            let ele = $(this);
            $.ajax({
                type: 'GET',
                url: `{{ url('/messages/${id}/${text}') }}`, // Route to your Laravel controller method
                success: function(response) {
                    // Handle the successful response from the server
                    console.log(response);
                    if(response.message){
                        ele.after(`<div class="text-success">${response.message}</div>`);
                    }else{
                        ele.after(`<div class="text-danger">Something went wrong.</div>`);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        })

    });
</script>
@endsection


