
<table class="w-full text-sm text-left rtl:text-right text-gray-800 dark:text-gray-200 {{ $margin }}">
    <thead class="text-xs font-bold text-gray-700 uppercase bg-gray-300 dark:bg-gray-600 dark:text-gray-100">
    <tr>
        @if($indexed === true)
            <th scope="col" class="px-3 py-3 w-1">
                #
            </th>
        @endif
        @foreach($fields as $key => $field)
            <th scope="col" class="py-3">
                @if(is_object($field))
                    {{ $field->label }}
                @else
                    {{$field}}
                @endif
            </th>
        @endforeach
        @if(count($actions)>0)
            <th scope="col" class="px-6 py-3 text-center">
                Actions
            </th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dataset as $index => $row)
        <tr class="odd:bg-gray-50 odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-700 border-b dark:border-gray-700 border-gray-200">
            @if($indexed === true)
                <td class="px-3 py-2 w-1">
                    @if($isPaginated)
                        {{ $index + 1 + ($dataset->currentPage() - 1) * $dataset->perPage() }}
                    @else
                        {{ $index + 1 }}
                    @endif
                </td>
            @endif
            @foreach($fields as $key => $field)
                @php
                    if(is_object($field)){
                        $key  = $field->key;
                    }
                @endphp
                @if($key === $highlight)
                    <th scope="row" class="py-2 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                        {{ ((array) $row)[$key] }}
                    </th>
                @else
                    <td class="py-2">
                        {{ ((array) $row)[$key] }}
                    </td>
                @endif
            @endforeach
            @if(count($actions)>0)
                <td class="py-2 text-center">
                    @foreach($actions as $action)
                        @include("pixelwrap::components/{$theme}/button",["button" => $action, "context" => (array)$row])
                    @endforeach
                </td>
            @endif
        </tr>
    @empty
        <tr class="bg-gray-200">
            <td class="px-3 py-2" colspan="{{ $fieldCount + ($indexed ? 1: 0) + (count($actions)>0 ? 1:0) }}">
                <p class="text-md font-normal">
                    {{ $table->emptyMessage ?? "Nothing here." }}
                </p>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

{{-- Pagination Controls (only if dataset is paginated) --}}
@if($isPaginated)
    <div class="px-0 py-3">
        {{ $dataset->links('pagination::tailwind') }}
    </div>
@endif
