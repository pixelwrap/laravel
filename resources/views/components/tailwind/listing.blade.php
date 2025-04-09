<div class="grid {{$listing->classes}}">
    @forelse($listing->dataset as $index => $row)
        @foreach($listing->nodes as $node)
            @php
                $rendered = $node->render($row->toArray());
            @endphp
            @if($rendered)
            <div class="{{$node->spanClasses}}">
                {{$rendered}}
            </div>
            @endif
        @endforeach
    @empty
        @if($listing->showEmptyMessage)
            <div class="px-3 py-2">
                <p class="text-md font-normal dark:text-gray-50">
                    {{ $listing->emptyMessage ?? "Nothing here." }}
                </p>
            </div>
        @endif
    @endforelse
</div>
