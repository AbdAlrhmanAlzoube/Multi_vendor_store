        @if (session()->has( $type ))
            <div class="alert alert-{{ $type }}">
              {{  session($type)}}
            </div>
        @endif
        {{-- @if (session()->has('info'))
        <div class="alert alert-info" role="alert">
            {{  session('info')}}
            </div>
        @endif
        @if (session()->has('danger'))
            <div class="alert alert-danger">
              {{  session('danger')}}
            </div>
        @endif --}}