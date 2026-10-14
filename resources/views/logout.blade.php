{{ $role = request()->user()->role }}

{{-- {{ $role }} --}}



<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>
