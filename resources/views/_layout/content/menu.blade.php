<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        @foreach($menu as $row)
            <li role="presentation" class="">
                <a href="#tab_{{ $row['tab'] }}" id="{{ $row['tab'] }}" role="tab" data-toggle="tab" aria-expanded="true">{{ Str::title($row['name']) }}</a>
            </li>
        @endforeach
    </ul>
    <div id="myTabContent" class="tab-content">
        @foreach($menu as $row)
            <div role="tabpanel" class="tab-pane fade" id="tab_{{ $row['tab'] }}" aria-labelledby="{{ $row['tab'] }}">
                @foreach($row['chld'] as $chld)
                    <button type="button" class="btn btn-default accKeyProcess" data-acckey="{{ $chld['accKey'] }}">
                        {{ Str::title($chld['name']) }}
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>
</div>