<div class="grid {{$listing->classes}}">
    @forelse($listing->dataset as $index => $row)
        @foreach($listing->nodes as $node)
            {{ $node->render($row->toArray()) }}
        @endforeach
    @empty
        <div class="px-3 py-2">
            <p class="text-md font-normal">
                {{ $listing->emptyMessage ?? "Nothing here." }}
            </p>
        </div>
    @endforelse
</div>
