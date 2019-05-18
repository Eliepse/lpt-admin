<div class="modal" tabindex="-1" role="dialog" id="{{ $label }}" aria-label="{{ $label }}">
    <div class="modal-dialog {{ $size ?? '' }}" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    {{--<span aria-hidden="true"></span>--}}
                </button>
            </div>

            <div class="modal-body">
                {{ $slot }}
            </div>

            @empty($noFooter)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Ok</button>--}}
                </div>
            @endempty

        </div>
    </div>
</div>