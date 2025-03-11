<div class="overflow-x-auto">
    <table class="{{$table->classes ?? '' }}">
        <thead>
        @if($table->showHeader === true)
            <tr>
                @if(count($table->headers) > 0)
                    <th class="bg-gray-0"></th>
                @endif
                @if($table->indexed === true)
                    <th scope="col" class="px-3 py-3 w-1 {{ $table->headingClasses ?? '' }}">
                        #
                    </th>
                @endif
                @foreach($table->fields as $key => $field)
                    <th scope="col" class="px-3 py-3 text-left {{ $table->headingClasses ?? '' }}">
                        {{$field->text(get_defined_vars())}}
                    </th>
                @endforeach
                @if(count($table->actions)>0)
                    <th scope="col" class="px-2 py-3 text-center {{ $table->headingClasses ?? '' }}">
                        Actions
                    </th>
                @endif
            </tr>
        </thead>
        @endif
        <tbody>
        @foreach($table->dataset as $datasetIndex => $dataset)
            @if(count($table->headers) > 0)
                <tr>
                    <td class="px-3 py-2 w-1 font-extrabold"
                        rowspan="{{ count($dataset) + (($table->aggregated && count($dataset)> 0) ? (1 + count($table->aggregate[$datasetIndex])): 1) + (count($dataset) > 0 ? 0 : 1) }}">
                        {{ $table->headers[$datasetIndex] }}
                    </td>
                    @if(count($dataset) ===0)
                        <td> {{ $table->emptyMessage }}</td>
                    @endif
                </tr>
            @endif
            @forelse($dataset as $index => $row)
                <tr class="{{ $table->rowClasses ?? '' }}">
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
                <tr class="{{ $table->rowClasses ?? '' }}">
                    @if(count($table->headers) === 0)
                        <td class="px-3 py-2"
                            colspan="{{ $table->fieldCount + ($table->indexed ? 1: 0) + (count($table->actions)>0 ? 1:0) }}">
                            <p class="text-md font-normal">
                                {{ $table->emptyMessage }}
                            </p>
                        </td>
                    @endif
                </tr>
            @endforelse

            @if($table->aggregated)
                @foreach($table->aggregate[$datasetIndex] as $key => $agg)
                    @if(count($dataset) > 0)
                        <tr class="">
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
                    @endif
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>

    @if($table->isPaginated)
        <div class="px-0 py-3">
            {{ $table->paginator->links("pixelwrap::components/tailwind/pagination") }}
        </div>
    @endif
</div>
