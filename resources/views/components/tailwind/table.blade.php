<div class="overflow-x-auto">
    <table
        class="table-auto w-full text-sm text-left rtl:text-right text-gray-800 dark:text-gray-200 {{$table->classes}}">
        <thead class="text-xs font-bold text-gray-700 uppercase bg-gray-300 dark:bg-gray-600 dark:text-gray-100">
        <tr>
            @if($table->indexed === true)
                <th scope="col" class="px-3 py-3 w-1">
                    #
                </th>
            @endif
            @foreach($table->fields as $key => $field)
                <th scope="col" class="px-3 py-3 text-left">
                    {{$field->label}}
                </th>
            @endforeach
            @if(count($table->actions)>0)
                <th scope="col" class="px-2 py-3 text-center">
                    Actions
                </th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($table->dataset as $index => $row)
            <tr class="odd:bg-gray-50 odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-700 border-b dark:border-gray-700 border-gray-200">
                @if($table->indexed === true)
                    <td class="px-3 py-2 w-1">
                        @if($table->isPaginated)
                            {{ $index + 1 + ($table->paginator->currentPage() - 1) * $table->paginator->perPage() }}
                        @else
                            {{ $index + 1 }}
                        @endif
                    </td>
                @endif
                @foreach($table->fields as $key => $field)
                    @if($key === $table->highlight)
                        <th scope="row"
                            class="px-3 py-2 font-bold text-gray-900 whitespace-nowrap dark:text-gray-200 text-left">
                            {{$field->value($row)}}
                        </th>
                    @else
                        <td class="px-3 py-2 text-left">
                            {{$field->value($row)}}
                        </td>
                    @endif
                @endforeach
                @if(count($table->actions)>0)
                    <td class="py-1 flex flex-row justify-center gap-x-2">
                        @foreach($table->actions as $action)
                            {{$action->render($row->toArray())}}
                        @endforeach
                    </td>
                @endif
            </tr>
        @empty
            <tr class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white">
                <td class="px-3 py-2"
                    colspan="{{ $table->fieldCount + ($table->indexed ? 1: 0) + (count($table->actions)>0 ? 1:0) }}">
                    <p class="text-md font-normal">
                        {{ $table->table->emptyMessage ?? "Nothing here." }}
                    </p>
                </td>
            </tr>
        @endforelse
        </tbody>
        @if($table->aggregated)
            <tfoot class="text-xs font-bold text-gray-700 uppercase bg-gray-300 dark:bg-gray-600 dark:text-gray-100">
            @foreach($table->aggregate as $key => $agg)
                <tr class="odd:bg-gray-50 odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-700 border-b dark:border-gray-700 border-gray-200">
                    @if($table->indexed === true)
                        <td class="px-3 py-2" colspan="2">{{ $key }}</td>
                    @else
                        <td class="px-3 py-2">{{ $key }}</td>
                    @endif
                    @foreach(array_slice($table->fields, 1) as $field)
                        @if(in_array($field->key, array_keys($agg)))
                            <td class="px-3 py-2">{{ $field->value($agg) }}</td>
                        @else
                            <td class="px-3 py-2">-</td>
                        @endif
                    @endforeach
                    @if(count($table->actions)>0)
                        <td class="py-1 flex flex-row justify-center gap-x-2">
                            -
                        </td>
                    @endif
                </tr>
            @endforeach
            </tfoot>
        @endif
    </table>

    @if($table->isPaginated)
        <div class="px-0 py-3">
            {{ $table->paginator->links("pixelwrap::components/tailwind/pagination") }}
        </div>
    @endif
</div>
