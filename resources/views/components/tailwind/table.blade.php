@php
    $datasetname = $node->dataset;
    $dataset = $$datasetname;
    $dataKey = $node->key ?? 'id';
    $dataKeyValue = $node->keyValue ?? $node->key ?? null;

    // Detect if dataset is paginated
    $isPaginated = $dataset instanceof \Illuminate\Pagination\LengthAwarePaginator || $dataset instanceof \Illuminate\Pagination\Paginator;

@endphp
<table class="w-full text-sm text-left rtl:text-right text-gray-700">
    <thead class="text-xs text-gray-200 uppercase bg-gray-600 ">
    <tr>
        @if($table->indexed === true)
            <th scope="col" class="px-3 py-3 w-1">
                #
            </th>
        @endif
        @foreach($table->fields as $key => $field)
            <th scope="col" class="py-3">
                {{$field}}
            </th>
        @endforeach
        @if(isset($table->actions) && count($table->actions)>0)
            <th scope="col" class="px-6 py-3 text-center">
                Actions
            </th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dataset as $index => $row)
        <tr class="odd:bg-gray-200  even:bg-gray-50  border-b">
            @if($table->indexed === true)
                <td class="px-3 py-2 w-1">
                    {{-- Adjust index based on pagination --}}
                    @if($isPaginated)
                        {{ $index + 1 + ($dataset->currentPage() - 1) * $dataset->perPage() }}
                    @else
                        {{ $index + 1 }}
                    @endif
                </td>
            @endif
            @foreach($table->fields as $key => $field)
                @if($key === $table->highlight)
                    <th scope="row" class="py-2 font-medium text-gray-900 whitespace-nowrap">
                        {{ $row->{$key} }}
                    </th>
                @else
                    <td class="py-2">
                        {{ $row->{$key} }}
                    </td>
                @endif
            @endforeach
            @if(isset($table->actions) && count($table->actions)>0)
                <td class="py-2 text-center">
                    @foreach($table->actions as $action)
                        <a href="{{ route($action->route->name, [...((array) $action->route->params), $dataKey => $row->{$dataKeyValue} ]) }}"
                           class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-sm text-sm px-4 py-1 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">{{$action->label}}</a>
                    @endforeach
                </td>
            @endif
        </tr>
    @empty
        <tr class="bg-gray-200">
            <td class="px-3 py-2"
                colspan="{{ count(get_object_vars($table->fields)) + ($table->indexed ? 1: 0) + (isset($table->actions) && count($table->actions)>0 ? 1:0)}}">
                <p class="text-md font-normal">
                    {{ $table->emptyMessage ?? "Nothing here." }}
                </p>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<!-- Pagination Controls (only if dataset is paginated) -->
@if($isPaginated)
    <div class="px-0 py-3">
        {{ $dataset->links('pagination::tailwind') }}
    </div>
@endif
