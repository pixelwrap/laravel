@php
    $ignoreNodes =  $ignoreNodes ?? true;
    $errors = $component->errors ?? $errors;
@endphp
<div class="border-2 border-red-600 dark:border-red-600 me-1 {{ $component->classes }}">
    @foreach($errors as $error)
        <p class="text-start text-wrap text-lg p-1 bg-red-600 dark:bg-red-600 text-gray-100 dark:text-gray-900">
            {{$error }}
        </p>
    @endforeach
    <p class="text-start text-sm p-1 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
        Yaml Snippet
    </p>
    <div class="text-start text-gray-700 dark:text-gray-50 text-sm m-1 code-block">
        <code>
            @foreach(explode("\n", renderComponentSource($component)) as $line)
                <pre>{{$line}} &nbsp;</pre>
            @endforeach
        </code>
    </div>
</div>
<style>
    .code-block {
        position: relative;
        counter-reset: line;
        padding-left: 30px;
        padding-top: 0;
    }

    .code-block code {
        display: block;
        white-space: collapse;
    }

    .code-block code pre {
        display: block;
        counter-increment: line;
    }

    .code-block code pre:before {
        content: counter(line) " ";
        position: absolute;
        left: 0;
        width: 30px;
        text-align: right;
    }
</style>
