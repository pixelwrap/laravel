<div class="border-2 border-red-600 dark:border-red-600">
    <p class="text-start text-wrap text-lg p-1 bg-red-600 dark:bg-red-600 text-gray-100 dark:text-gray-900">
        {{ implode(", ", $errors) }}
    </p>
    <p class="text-start text-sm px-1 bg-gray-300 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
        Yaml Snippet
    </p>
    <div class="text-start text-gray-700 dark:text-gray-50 text-sm m-1">
        <code class="whitespace-pre">{{ renderComponentSource($component) }}</code>
    </div>
</div>
