
@if(Session::has('message'))
    <div class="alert alert-dismissible alert-{{ session('message-level') }}" role="alert" style="margin: 4% 15% 0 15%">

        <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true"> &times; </span> <span class="sr-only">Close</span></button>
        {{ Session('message') }}
    </div>
@endif
