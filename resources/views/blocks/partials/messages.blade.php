@if(count($messages))
<div class="row">
    <div class="col-12 mt-4 text-center text-muted">
        Other Counterparty Messages:<br />
        @foreach($messages as $message)
            @if($message->count > 1)
            {{ ucfirst($message->command) }} {{ str_replace('_', ' ', str_plural(getTitleFromType($message->category), $message->count)) }} ({{ $message->count }}){{ $loop->last ? '.' : ',' }}
            @else
            {{ ucfirst($message->command) }} {{ str_replace('_', ' ', str_plural(getTitleFromType($message->category), $message->count)) }}{{ $loop->last ? '.' : ',' }}
            @endif
        @endforeach
    </div>
</div>
@endif