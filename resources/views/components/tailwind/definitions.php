<?php
$columnOptions = [
    // Small grids (1-4): Progressive steps with simple responsive scaling
    "1"  => "grid-cols-1",
    "2"  => "grid-cols-1 sm:grid-cols-2",
    "3"  => "grid-cols-1 sm:grid-cols-2 md:grid-cols-3",
    "4"  => "grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4",

    // Medium grids (5-8): More columns on larger screens, but careful growth on smaller ones
    "5"  => "grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5",
    "6"  => "grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6",
    "7"  => "grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7",
    "8"  => "grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8",

    // Large grids (9-12): Advanced layouts for larger screens
    "9"  => "grid-cols-3 sm:grid-cols-5 md:grid-cols-7 lg:grid-cols-9",
    "10" => "grid-cols-3 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10",
    "11" => "grid-cols-3 sm:grid-cols-6 md:grid-cols-9 lg:grid-cols-11",
    "12" => "grid-cols-4 sm:grid-cols-6 md:grid-cols-9 lg:grid-cols-12",
];

$colSpanOptions = [
    // Small spans - carefully designed to work across any grid size
    "1"  => "col-span-1",
    "2"  => "col-span-2",
    "3"  => "col-span-6 md:col-span-6 lg:col-span-3",

    // Medium spans - balanced for different grid sizes
    "4"  => "col-span-6 sm:col-span-4 md:col-span-4",
    "5"  => "col-span-full sm:col-span-5 md:col-span-5",
    "6"  => "col-span-full sm:col-span-6 md:col-span-6",

    // Large spans - designed to work with 12-column grid
    "7"  => "col-span-full md:col-span-7",
    "8"  => "col-span-full md:col-span-8",
    "9"  => "col-span-full md:col-span-9",

    // Full width control with breakpoints
    "10" => "col-span-full md:col-span-10",
    "11" => "col-span-full md:col-span-11",
    "12" => "col-span-full",

    // Special cases
    "1/4" => "col-span-full sm:col-span-6 md:col-span-3",
    "1/3" => "col-span-full sm:col-span-6 md:col-span-4",
    "1/2" => "col-span-full sm:col-span-6",
    "2/3" => "col-span-full md:col-span-8",
    "3/4" => "col-span-full md:col-span-9",
    "default" => "",
];

$gapOptions = [
    "smallest"      => "gap-1",
    "smaller"       => "gap-3",
    "small"         => "gap-6",
    "big"           => "gap-8",
    "bigger"        => "gap-10",
    "biggest"       => "gap-16",
    "none"          => "gap-0",
    "default"       => "",
    "x-smallest"    => "gap-x-1",
    "x-smaller"     => "gap-x-3",
    "x-small"       => "gap-x-6",
    "x-big"         => "gap-x-8",
    "x-bigger"      => "gap-x-10",
    "x-biggest"     => "gap-x-16",
    "x-none"        => "gap-x-0",
    "y-smallest"    => "gap-y-1",
    "y-smaller"     => "gap-y-3",
    "y-small"       => "gap-y-6",
    "y-big"         => "gap-y-8",
    "y-bigger"      => "gap-y-10",
    "y-biggest"     => "gap-y-16",
    "y-none"        => "gap-y-0",
];

$marginOptions = [
    "smallest"        => "m-1",
    "smaller"         => "m-3",
    "small"           => "m-6",
    "big"             => "m-8",
    "bigger"          => "m-10",
    "biggest"         => "m-16",
    "none"            => "m-0",
    "default"         => "",
    "left-smallest"   => "ml-1",
    "left-smaller"    => "ml-3",
    "left-small"      => "ml-6",
    "left-big"        => "ml-8",
    "left-bigger"     => "ml-10",
    "left-biggest"    => "ml-16",
    "left-none"       => "ml-0",
    "right-smallest"  => "mr-1",
    "right-smaller"   => "mr-3",
    "right-small"     => "mr-6",
    "right-big"       => "mr-8",
    "right-bigger"    => "mr-10",
    "right-biggest"   => "mr-16",
    "right-none"      => "mr-0",
    "top-smallest"    => "mt-1",
    "top-smaller"     => "mt-3",
    "top-small"       => "mt-6",
    "top-big"         => "mt-8",
    "top-bigger"      => "mt-10",
    "top-biggest"     => "mt-16",
    "top-none"        => "mt-0",
    "bottom-smallest" => "mb-1",
    "bottom-smaller"  => "mb-3",
    "bottom-small"    => "mb-6",
    "bottom-big"      => "mb-8",
    "bottom-bigger"   => "mb-10",
    "bottom-biggest"  => "mb-16",
    "bottom-none"     => "mb-0",
    "x-smallest"      => "mx-1",
    "x-smaller"       => "mx-3",
    "x-small"         => "mx-6",
    "x-big"           => "mx-8",
    "x-bigger"        => "mx-10",
    "x-biggest"       => "mx-16",
    "x-none"          => "mx-0",
    "y-smallest"      => "my-1",
    "y-smaller"       => "my-3",
    "y-small"         => "my-6",
    "y-big"           => "my-8",
    "y-bigger"        => "my-10",
    "y-biggest"       => "my-16",
    "y-none"          => "my-0",
];

$paddingOptions = [
    "smallest"          => "p-1",
    "smaller"           => "p-3",
    "small"             => "p-6",
    "big"               => "p-8",
    "bigger"            => "p-10",
    "biggest"           => "p-16",
    "none"              => "p-0",
    "default"           => "",
    "left-smallest"     => "pl-1",
    "left-smaller"      => "pl-3",
    "left-small"        => "pl-6",
    "left-big"          => "pl-8",
    "left-bigger"       => "pl-10",
    "left-biggest"      => "pl-16",
    "left-none"         => "pl-0",
    "right-smallest"    => "pr-1",
    "right-smaller"     => "pr-3",
    "right-small"       => "pr-6",
    "right-big"         => "pr-8",
    "right-bigger"      => "pr-10",
    "right-biggest"     => "pr-16",
    "right-none"        => "pr-0",
    "top-smallest"      => "pt-1",
    "top-smaller"       => "pt-3",
    "top-small"         => "pt-6",
    "top-big"           => "pt-8",
    "top-bigger"        => "pt-10",
    "top-biggest"       => "pt-16",
    "top-none"          => "pt-0",
    "bottom-smallest"   => "pb-1",
    "bottom-smaller"    => "pb-3",
    "bottom-small"      => "pb-6",
    "bottom-big"        => "pb-8",
    "bottom-bigger"     => "pb-10",
    "bottom-biggest"    => "pb-16",
    "bottom-none"       => "pb-0",
    "x-smallest"        => "px-1",
    "x-smaller"         => "px-3",
    "x-small"           => "px-6",
    "x-big"             => "px-8",
    "x-bigger"          => "px-10",
    "x-biggest"         => "px-16",
    "x-none"            => "px-0",
    "y-smallest"        => "py-1",
    "y-smaller"         => "py-3",
    "y-small"           => "py-6",
    "y-big"             => "py-8",
    "y-bigger"          => "py-10",
    "y-biggest"         => "py-16",
    "y-none"            => "py-0",
];

$borderOptions = [
    "smallest"          => "border border-1",
    "smaller"           => "border border-2",
    "small"             => "border border-4",
    "big"               => "border border-8",
    "bigger"            => "border border-16",
    "none"              => "border-0",
    "default"           => "",
    "top-smallest"      => "border-t border-t-1",
    "top-smaller"       => "border-t border-t-2",
    "top-small"         => "border-t border-t-4",
    "top-big"           => "border-t border-t-8",
    "top-bigger"        => "border-t border-t-16",
    "top-none"          => "border-t-0",
    "right-smallest"    => "border-r border-r-1",
    "right-smaller"     => "border-r border-r-2",
    "right-small"       => "border-r border-r-4",
    "right-big"         => "border-r border-r-8",
    "right-bigger"      => "border-r border-r-16",
    "right-none"        => "border-r-0",
    "bottom-smallest"   => "border-b border-b-1",
    "bottom-smaller"    => "border-b border-b-2",
    "bottom-small"      => "border-b border-b-4",
    "bottom-big"        => "border-b border-b-8",
    "bottom-bigger"     => "border-b border-b-16",
    "bottom-none"       => "border-b-0",
    "left-smallest"     => "border-l border-l-1",
    "left-smaller"      => "border-l border-l-2",
    "left-small"        => "border-l border-l-4",
    "left-big"          => "border-l border-l-8",
    "left-bigger"       => "border-l border-l-16",
    "left-none"         => "border-l-0",
];

$headingTypes = [
    "biggest"   => "text-4xl",
    "bigger"    => "text-3xl",
    "big"       => "text-2xl",
    "small"     => "text-xl",
    "smaller"   => "text-ld",
    "smallest"  => "text-sm"
];

$buttonVariants  = [
    "primary"   => "rounded-sm text-white border border-1 border-blue-700 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-1    focus:ring-blue-300 font-medium dark:border-blue-600 dark:bg-blue-600   dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 print:hidden",
    "secondary" => "rounded-sm text-white border border-1 border-gray-700 bg-gray-700 hover:bg-gray-900 focus:outline-none focus:ring-1    focus:ring-gray-300 font-medium dark:bg-blue-600 dark:bg-gray-600       dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 print:hidden",
    "success"   => "rounded-sm text-white border border-1 border-green-700 bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-1 focus:ring-green-300 font-medium dark:bg-green-600 dark:bg-green-600    dark:hover:bg-green-700 dark:focus:ring-green-700 dark:border-green-700 print:hidden",
    "danger"    => "rounded-sm text-white border border-1 border-red-700 bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-1       focus:ring-red-300 font-medium dark:bg-red-600 dark:bg-red-600          dark:hover:bg-red-700 dark:focus:ring-red-900 dark:border-red-900 print:hidden",
    "icon"      => "rounded-full text-gray-500 border-gray-500 border border-1 bg-white flex justify-center items-center p-2 hover:text-gray-900 dark:border-gray-400 shadow-xs dark:hover:text-white dark:text-gray-50 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-950 focus:ring-1 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400 print:hidden",
];

$buttonSizes = [
    "biggest"   => "text-xl px-6 py-4",
    "bigger"    => "text-lg px-5 py-3",
    "big"       => "test-md px-4 py-2.5",
    "small"     => "text-sm px-3 py-2",
    "smaller"   => "text-sm px-3 py-1.5",
    "smallest"  => "text-xs px-3 py-1"
];

$iconSizes = [
    "biggest"   => "p-6",
    "bigger"    => "p-5",
    "big"       => "p-4",
    "small"     => "p-3",
    "smaller"   => "p-2",
    "smallest"  => "p-1"
];

$inputVariants  = [
    "primary"   => "w-full p-2 text-sm text-gray-900 dark:text-gray-50 bg-white dark:bg-gray-800 border border-gray-600 dark:border-gray-400 rounded-sm shadow-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 focus:outline-none",
    "disabled"  => "bg-gray-50 dark:bg-gray-400 disabled:opacity:50 cursor-not-allowed"
];

$inputLabelVariants  = [
    "primary"   => "block my-1 text-sm font-medium text-gray-800 dark:text-gray-50",
    "disabled"  => "disabled:opacity:50 cursor-not-allowed"
];
