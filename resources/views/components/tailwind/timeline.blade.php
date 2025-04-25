<ol @class([
    "relative border-gray-700 dark:border-gray-50",
    $timeline->classes,
     "border-s" => $timeline->orientation === "vertical" ,
     "items-center sm:flex" => $timeline->orientation === "horizontal"
   ])>
    @if($timeline->dataset)
        @foreach($timeline->dataset as $row)
            @foreach($timeline->nodes as $event)
                @include("pixelwrap::components/{$timeline->theme}/timeline-event",[ ...get_defined_vars(), ...$row, "timeline" => $timeline, "event" => $event])
            @endforeach
        @endforeach
    @else
        @foreach($timeline->nodes as $event)
            @include("pixelwrap::components/{$timeline->theme}/timeline-event",[ ...get_defined_vars(), "timeline" => $timeline,"event" => $event])
        @endforeach
    @endif
</ol>
