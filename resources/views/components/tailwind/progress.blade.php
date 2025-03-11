<div class="w-full bg-gray-200 rounded-sm dark:bg-gray-700">
    <div class="bg-green-600 text-xs font-medium text-blue-100 text-center h-4 p-0.5 leading-none rounded-none {{ $progress->classes }}"
         style="width: {{$progress->value}}%">
        @if($progress->showLabel)
            {{$progress->value}}%
        @endif
    </div>
</div>
